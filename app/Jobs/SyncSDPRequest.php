<?php

namespace App\Jobs;

use App\Attachment;
use App\BusinessUnit;
use App\Category;
use App\Helpers\ServiceDeskApi;
use App\Item;
use App\Status;
use App\Subcategory;
use App\Ticket;
use App\TicketReply;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\DomCrawler\Crawler;

class SyncSDPRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int*/
    protected $sdp_id;

    /** @var ServiceDeskApi */
    protected $api;

    public function fail($exception = null)
    {
        \Log::warning("sdp-sync: Request $this->sdp_id has failed to sync");
    }

    /** @var Client */
    protected $webClient;

    /** @var array */
    protected $statusMap = [
        'Open' => 1,
        'Onhold' => 4,
        'Closed' => 9
    ];

    function __construct($sdp_id)
    {
        $this->sdp_id = $sdp_id;
    }

    function handle(ServiceDeskApi $api)
    {
        $this->api = $api;

        $request = $this->api->getRequest($this->sdp_id);
        $requester = User::where('name', $request['requester'])->first();
        if (!$requester) {
            $requester = $this->getRequesterFromSDP($request['requester']);
        }

        $createdby = User::where('name', $request['createdby'])->first();

        $is_template = ($request['is_catalog_template'] ?? '') == "true";
        if (!$is_template) {
            $category = Category::where('name', $request['category'])->first();
            $subcategory = Subcategory::where('name', $request['subcategory'] ?? '')->first();
            $item = Item::where('name', $request['item'] ?? '')->first();
            $additionalFields = [];
        } else {
            $attributes = $this->fetchRequestFromWeb($this->sdp_id);
            $category = Category::where('name', $attributes['category'] ?? '')->first();
            $subcategory = Subcategory::where('name', $request['requesttemplate'] ?? '')->first();
            $additionalFields = $attributes['additionalFields'];
        }

        $query = Ticket::where('sdp_id', $request['workorderid']);
        if (!$query->exists()) {
            if (!$requester) {
                \Log::warning("[sdp-sync] Requester not found: " . $request['requester']);
                return;
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
            dispatch(new ApplyBusinessRules($ticket));
            dispatch(new ApplySLA($ticket));
            dispatch(new NewTicketJob($ticket));

            $this->handleAttachments($ticket);
            $this->syncConversations($ticket);
        } else {
            $ticket = $query->first();
            if ($ticket->status->name != $request['status'] && in_array($ticket->status_id,[7,8,9])) {
                $status = Status::find($this->statusMap[$request['status']]);
                $query->update(['status_id' => $status->id]);
            }
            $ticket = $query->first();
            $this->syncConversations($ticket);
        }
    }

    protected function syncConversations(Ticket $ticket)
    {
        $conversations = $this->api->getConversations($ticket->sdp_id);
        foreach ($conversations as $conversation) {
            \Log::info("[sync-sdp] Syncing conversation {$conversation['conversationid']}");
            if (TicketReply::where('sdp_id', $conversation['conversationid'])->exists()) {
                \Log::info("[sync-sdp] Conversation {$conversation['conversationid']} already found");
                continue;
            }

            $details = $this->api->getConversation($ticket->sdp_id, $conversation['conversationid']);
            $user = User::where('name', $details['from'])->first();
            if (!$user) {
                $user = $this->getRequesterFromSDP($details['from']);

                if (!$user) {
                    continue;
                }
            }

            $by = $user->id;

            $reply = $ticket->replies()->create([
                'user_id' => $by,
                'status_id' => 1,
                'content' => $details['description'],
                'sdp_id' => $conversation['conversationid'],
                'is_resolution' => false
            ]);
            \Log::info("[sync-sdp] Conversation {$conversation['conversationid']} synced to {$reply->id}");

            /** @var TicketReply $reply */
            $this->getReplyAttachments($reply);
        }
    }

    function getReplyAttachments(TicketReply $reply){
      $client = $this->webLogin();
      $response = $client->get("/workorder/UpdateNotificationDetails.jsp?woID={$reply->sdp_id}&orgReqID={$reply->ticket->sdp_id}");

      $parser = new Crawler();
      $parser->addHtmlContent($content = $response->getBody()->getContents());

        foreach ($parser->filter('.attachfileicon') as $icon) {
            $path = $icon->parentNode->attributes['href']->value;
            $filename = "/attachments/{$reply->ticket->id}/" . $icon->nextSibling->textContent;
            $storage_path = storage_path('app/public' . $filename);

            if (!is_dir($dir = dirname($storage_path))) {
                mkdir($dir, 0775, true);
            }

            $client->get($path, ['sink' => $storage_path]);
            
            $attachment = new Attachment();
            $attachment->type = 2;
            $attachment->reference = $reply->id;
            $attachment->path = $filename;
            $attachment->save();
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
    protected function webLogin()
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

    protected function getRequesterFromSDP($name)
    {
        $attributes = $this->api->getRequester($name);

        $company = $this->getCompanyForRequester($name, $attributes['emailid']);
        $businessUnit = BusinessUnit::where('name', $company)->first();

        if (!$businessUnit) {
            return false;
        }
        $user = User::withTrashed()->where('email',$attributes['emailid'])->first();

        if (!$user) {

            $user = User::create([
                'email' => $attributes['emailid'],
                'login' => $attributes['loginname'],
                'name' => $name,
                'mobile1' => $attributes['mobile'],
                'phone' => $attributes['landline'],
                'job' => $attributes['jobtitle'],
                'business_unit_id' => $businessUnit->id,
            ]);
        }
        if ($user->deleted_at) {
            $user->deleted_at = null;
            $user->save();
        }

        return $user;
    }

    protected function getCompanyForRequester($name, $email)
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
            <name>E-Mail</name>
            <name>Company</name>
        </returnFields>
         <range>
            <startindex>1</startindex>
            <limit>50</limit>
        </range>
</citype>
</API>";

        $result = $this->api->send('/api/cmdb/ci/', 'read', $xml);

        $company = '';
        foreach ($result->response->operation->Details->{'field-values'}->record as $record) {
            $record_email = strval($record->value[0]);
            if ($record_email == $email) {
                $company = strval($record->value[1]);
            }
        }

        return $company;
    }
}
