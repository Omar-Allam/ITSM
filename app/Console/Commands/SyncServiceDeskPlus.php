<?php

namespace App\Console\Commands;

use App\Attachment;
use App\BusinessUnit;
use App\Category;
use App\Helpers\ServiceDeskApi;
use App\Item;
use App\Jobs\ApplyBusinessRules;
use App\Jobs\ApplySLA;
use App\Jobs\NewTicketJob;
use App\Status;
use App\Subcategory;
use App\Ticket;
use App\TicketReply;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\DomCrawler\Crawler;

class SyncServiceDeskPlus extends Command
{
    protected $signature = 'sdp:sync';

    protected $description = 'Sync with Manage Engine ServiceDesk Plus';

    /**
     * @var ServiceDeskApi
     */
    protected $api;

    protected $statusMap = [
        'Open' => 1,
        'Onhold' => 4
    ];

    protected $webClient = null;

    public function __construct(ServiceDeskApi $api)
    {
        parent::__construct();
        $this->api = $api;
    }

    public function handle()
    {
        $this->getNewTicketFromSDP();
    }

    protected function getNewTicketFromSDP()
    {
        Ticket::unguard();
        Attachment::flushEventListeners();

//        $ids = [96976];
        $requests = $this->api->getRequests();
        $ids = array_map('intval', array_pluck($requests, 'workorderid'));

        $counter = 0;
        Ticket::flushEventListeners();

        foreach ($ids as $id) {
            $request = $this->api->getRequest($id);

            $requester = User::where('name', $request['requester'])->first();
            if (!$requester) {
                $requester = $this->getRequestFromSDP($request['requester']);
            }

            $createdby = User::where('name', $request['createdby'])->first();

            $is_template = ($request['is_catalog_template'] ?? '') == "true";
            if (!$is_template) {
                $category = Category::where('name', $request['category'])->first();
                $subcategory = Subcategory::where('name', $request['subcategory'] ?? '')->first();
                $item = Item::where('name', $request['item'] ?? '')->first();
                $additionalFields = [];
            } else {
                $attributes = $this->fetchRequestFromWeb($id);
                $category = Category::where('name', $attributes['category'] ?? '')->first();
                $subcategory = Subcategory::where('name', $request['requesttemplate'] ?? '')->first();
                $additionalFields = $attributes['additionalFields'];
            }

            $query = Ticket::where('sdp_id', $request['workorderid']);
            if (!$query->exists()) {
                if (!$requester) {
                    \Log::warning("[sdp-sync] Requester not found: " . $request['requester']);
                    continue;
                }

                $attributes = [
                    'requester_id' => $requester->id,
                    'creator_id' => $createdby->id ?? $requester->id,
                    'subject' => $request['subject'],
                    'description' => $request['description'],
                    'category_id' => $category->id ?? 0,
                    'subcategory_id' => $subcategory->id ?? 0,
                    'item_id' => $item->id ?? 0,
                    'sdp_id' => $request['workorderid'],
                    'status_id' => $this->statusMap[$request['status']]
                ];

                $ticket = Ticket::create($attributes);
                foreach ($additionalFields as $name => $value) {
                    $ticket->fields()->create(compact('name', 'value'));
                }
                dispatch(new NewTicketJob($ticket));
                dispatch(new ApplyBusinessRules($ticket));
                dispatch(new ApplySLA($ticket));

                $this->handleAttachments($ticket);
                $this->syncConversations($ticket);
                ++$counter;
            } else {
                $ticket = $query->first();
                $this->syncConversations($ticket);
            }
        }

        \Log::info("$counter tickets has been synchronized");
    }

    protected function syncConversations(Ticket $ticket)
    {
        $conversations = $this->api->getConversations($ticket->sdp_id);
        foreach ($conversations as $conversation) {
            if (TicketReply::where('sdp_id', $conversation['conversationid'])->exists()) {
                continue;
            }

            $details = $this->api->getConversation($ticket->sdp_id, $conversation['conversationid']);

            $user = User::where('name', $details['from'])->first();
            $by = $user->id;
            $fromRequester = $user->id == $ticket->requester_id;
            $status = $fromRequester? 1 : $ticket->status_id;

            $ticket->replies()->create([
                'user_id' => $by,
                'status_id' => $status,
                'content' => $details['description'],
                'sdp_id' => $conversation['conversationid'],
                'is_resolution' => false
            ]);
        }
    }

    /**
     * @param $id
     * @return array
     */
    protected function fetchRequestFromWeb($id)
    {
        $client = $this->webLogin();

        $response = $client->get("/WorkOrder.do?woMode=viewWO&woID=$id");

        $parser = new Crawler();
        $parser->addHtmlContent($content = $response->getBody()->getContents());


        /** @var Crawler $tags */
        $tags = $parser->filter('body #Spot_SERVICEID');

        $category = trim($tags->first()->text());

        $additionalFields = [];
        $matches = [];
        preg_match_all('/"ServiceReq_\d+_UDF_.*?_CUR"/', $content, $matches);
        if ($matches[0]) {
            foreach ($matches[0] as $match) {
                /** @var Crawler $node */
                $node = $parser->filter('body #' . trim($match, '""'))->first();
                $value = $node->text();

                $name = trim($node->parents()->filter('table')->filter('b')->text());
                $additionalFields[$name] = $value;
            }
        }

        return compact('category', 'additionalFields');
    }

    protected function handleAttachments($ticket)
    {
        $client = $this->webLogin();

        $response = $client->get("/WorkOrder.do?woMode=viewWO&woID={$ticket->sdp_id}");

        $parser = new Crawler();
        $parser->addHtmlContent($response->getBody()->getContents());

        /** @var \DOMElement $icon */
        foreach ($parser->filter('body .attachfileicon') as $icon) {
            $path = $icon->parentNode->attributes['href']->value;
            $filename = "/attachments/{$ticket->id}/" . $icon->nextSibling->textContent;
            $storage_path = storage_path('app/public' . $filename);

            if (!is_dir($dir = dirname($storage_path))) {
                mkdir($dir, 0775, true);
            }

            $client->get($path, ['sink' => $storage_path]);


            $attachment = new Attachment();
            $attachment->type = 1;
            $attachment->reference = $ticket->id;
            $attachment->path = $filename;
            $attachment->save();
        }
    }

    /**
     * @return Client
     */
    protected function webLogin(): Client
    {
        if ($this->webClient) {
            return $this->webClient;
        }

        $this->webClient = new Client([
            'base_uri' => config('services.sdp.base_url'),
            'cookies' => true
        ]);

        $domain = config('services.sdp.admin.domain');
        $response = $this->webClient->post('/j_security_check', [
            'form_params' => [
                'j_username' => config('services.sdp.admin.user'),
                'j_password' => config('services.sdp.admin.password'),
                'domain' => 0,
                'checkbox' => 'checkbox',
                'DOMAIN_NAME' => $domain,
                'DomainCount' => 1,
                'LocalAuth' => $domain ? 'No' : 'YES',
                'logonDomainName' => $domain,
                'loginButton' => 'Login'
            ]
        ]);

        return $this->webClient;
    }

    protected function getRequestFromSDP($name)
    {
        $attributes = $this->api->getRequester($name);

        $company = $this->getCompanyForRequester($name);
        $businessUnit = BusinessUnit::where('name', $company)->first();
        if ($name == 'Babar J. Cheema') {
            dd($company);
        }
        if (!$businessUnit) {
            return false;
        }

        $user = User::create([
            'email' => $attributes['emailid'],
            'login' => $attributes['loginname'],
            'name' => $name,
            'mobile1' => $attributes['mobile'],
            'phone' => $attributes['landline'],
            'job' => $attributes['jobtitle'],
            'business_unit_id' => $businessUnit->id,
        ]);

        return $user;
    }

    protected function getCompanyForRequester($name)
    {
        $xml = "<API version=\"1.0\" locale=\"en\">
<citype>
    <name>Requester</name> 
        <criterias>
            <criteria>
                <parameter>
                    <name compOperator=\"START WITH\">CI Name</name>
                    <value>$name</value>
                </parameter>
            </criteria>
        </criterias>
        <returnFields>
            <name>Company</name>
        </returnFields>
         <range>
            <startindex>1</startindex>
            <limit>50</limit>
        </range>
</citype>
</API>";

        $result = $this->api->send('/api/cmdb/ci/', 'read', $xml);
        return strval($result->response->operation->Details->{'field-values'}->record->value);
    }
}
