<?php

namespace App\Console\Commands;

use App\Category;
use App\Helpers\ServiceDeskApi;
use App\Item;
use App\Jobs\ApplyBusinessRules;
use App\Jobs\ApplySLA;
use App\Jobs\NewTicketJob;
use App\Status;
use App\Subcategory;
use App\Ticket;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SyncServiceDeskPlus extends Command
{
    protected $signature = 'sdp:sync';

    protected $description = 'Sync with Manage Engine ServiceDesk Plus';

    /**
     * @var ServiceDeskApi
     */
    protected $api;

    protected $statusMap = [
        'Open' => 1, 'Onhold' => 4
    ];

    public function __construct(ServiceDeskApi $api)
    {
        parent::__construct();
        $this->api = $api;
    }

    public function handle()
    {
        $this->getNewTicketFromSDP();
        $this->syncConversations();
    }

    protected function getNewTicketFromSDP()
    {
        Ticket::unguard();

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

            if (!Ticket::where('sdp_id', $request['workorderid'])->exists()) {
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
                ++$counter;
            }
        }

        \Log::info("$counter tickets has been synchronized");
    }

    protected function syncConversations()
    {
        /** @var Collection $tickets */
        $tickets = Ticket::hasSdp()->pending()->get();

        $tickets->each(function (Ticket $ticket) {

            $this->api->getConversations($ticket->sdp_id);

        });
    }


}
