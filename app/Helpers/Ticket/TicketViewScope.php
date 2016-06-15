<?php

namespace App\Helpers\Ticket;

use App\Status;
use App\TicketApproval;
use Illuminate\Database\Eloquent\Builder;

class TicketViewScope
{
    protected static $statusScopes = ['open', 'on_hold', 'pending', 'completed'];

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var Builder
     */
    private $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
        $this->user = \Auth::user();
    }

    public static function getScopes()
    {
        return [
            "my_open" => "My Open Tickets",
            "my_on_hold" => "My On-Hold Tickets",
            "my_pending" => "My Pending Tickets",
            "my_completed" => "My Completed Ticket",
            "mine" => "All My Tickets",
            'for_approval' => 'Ticket waiting my approval',
            "open_in_my_groups" => 'All Open Tickets',
            "on_hold_in_my_groups" => "All On-Hold Tickets",
            "pending_in_my_groups" => 'All Pending Tickets',
            "completed_in_my_groups" => 'All Completed Tickets',
            "in_my_groups" => "All Tickets",

//            "open" => 'All Open Tickets',
//            "on_hold" => "All On-Hold Tickets",
//            "pending" => 'All Pending Tickets',
//            "completed" => 'All Completed Tickets',
        ];

    }

    public function apply()
    {
        $scope = session('ticket.scope');

        if (method_exists($this, $scope)) {
            if (in_array($scope, self::$statusScopes)) {
                $this->in_my_groups();
            }

            call_user_func([$this, $scope]);
        } else {
            $this->my_pending();
        }
    }

    public function my_open()
    {
        $this->mine();
        $this->open();
    }

    public function my_on_hold()
    {
        $this->mine();
        $this->on_hold();
    }

    public function my_pending()
    {
        $this->mine();
        $this->pending();
    }

    public function my_completed()
    {
        $this->mine();
        $this->completed();
    }

    public function mine()
    {
        $this->query->where(function(Builder $q) {
            $q->where('technician_id', $this->user->id)
                ->orWhere('requester_id', $this->user->id)
                ->orWhere('coordinator_id', $this->user->id);
        });
    }

    public function pending_in_my_groups()
    {
        $this->in_my_groups();
        $this->pending();
    }

    public function open_in_my_groups()
    {
        $this->in_my_groups();
        $this->open();
    }

    public function on_hold_in_my_groups()
    {
        $this->in_my_groups();
        $this->on_hold();
    }

    public function completed_in_my_groups()
    {
        $this->in_my_groups();
        $this->completed();
    }

    public function in_my_groups()
    {
        $this->query->whereIn('group_id', $this->user->groups->pluck('id')->toArray());
    }

    public function pending()
    {
        $this->query->whereHas('status', function(Builder $q){
            $q->whereIn('type', [Status::OPEN, Status::PENDING]);
        });
    }

    public function open()
    {
        $this->query->whereHas('status', function(Builder $q){
            $q->where('type', Status::OPEN);
        });
    }

    public function completed()
    {
        $this->query->whereHas('status', function(Builder $q){
            $q->where('type', Status::COMPLETE);
        });
    }

    public function on_hold()
    {
        $this->query->whereHas('status', function(Builder $q){
            $q->where('type', Status::PENDING);
        });
    }

    public function for_approval()
    {
        $this->query->whereHas('approvals', function(Builder $q){
            $q->where('approver_id', \Auth::user()->id)
                ->where('status', TicketApproval::PENDING_APPROVAL);
        });
    }
}