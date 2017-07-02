<?php

namespace App\Console\Commands;

use App\Attachment;
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

        $requests = $this->api->getRequests();

        $ids = array_map('intval', array_pluck($requests, 'workorderid'));
        $counter = 0;
        foreach ($ids as $id) {
            $request = $this->api->getRequest($id);

            $requester = User::where('name', $request['requester'])->first();
            $createdby = User::where('name', $request['createdby'])->first();

            $category = Category::where('name', $request['category'])->first();
            $subcategory = Subcategory::where('name', $request['subcategory'] ?? 0)->first();
            $item = Item::where('name', $request['item'] ?? 0)->first();

            $query = Ticket::where('sdp_id', $request['workorderid']);
            if (!$query->exists()) {
                if (!$requester) {
                    dump($request['requester']);
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

                Ticket::flushEventListeners();
                $ticket = Ticket::create($attributes);
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

            $fromRequester = $details['from'] == $ticket->requester->name;
            $by = $fromRequester? $ticket->requester_id : 0;
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

    protected function handleAttachments($ticket)
    {
        $client = $this->webLogin();

        $response = $client->get("/WorkOrder.do?woMode=viewWO&woID={$ticket->sdp_id}");

        $parser = new Crawler($response->getBody()->getContents());
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
}
