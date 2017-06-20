<?php

namespace App\Console\Commands;

use App\Category;
use App\Helpers\ServiceDeskApi;
use App\Item;
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
        foreach ($ids as $id) {
            $request = $this->api->getRequest($id);

            $requester = User::where('name', $request['requester'])->first();
            $createdby = User::where('name', $request['createdby'])->first();

            $category = Category::where('name', $request['category'])->first();
            $subcategory = Subcategory::where('name', $request['category'])->first();
            $item = Item::where('name', $request['category'])->first();

            if (!Ticket::where('sdp_id', $request['workorderid'])->exists()) {
                if (!$requester) {
                    dd($request['requester']);
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

                Ticket::create($attributes);
            }
        }
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
