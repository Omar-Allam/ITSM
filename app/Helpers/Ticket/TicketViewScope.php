<?php

namespace App\Helpers\Ticket;

use App\Status;
use App\TicketApproval;
use Carbon\Carbon;
use App\Ticket;
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
        $scopes = [
            "my_open" => "My Open Tickets",
            "my_on_hold" => "My On-Hold Tickets",
            "my_pending" => "My Pending Tickets",
            "my_completed" => "My Completed Ticket",
            'for_approval' => 'Ticket waiting my approval',
            "all_mine" => "All My Tickets",

//            "open" => 'All Open Tickets',
//            "on_hold" => "All On-Hold Tickets",
//            "pending" => 'All Pending Tickets',
//            "completed" => 'All Completed Tickets',
        ];

        if (\Auth::user()->isSupport()) {
            $scopes["open_in_my_groups"] = 'All Open Tickets';
            $scopes["on_hold_in_my_groups"] = "All On-Hold Tickets";
            $scopes["pending_in_my_groups"] = 'All Pending Tickets';
            $scopes["completed_in_my_groups"] = 'All Completed Tickets';
            $scopes["open_assigned_to_me"] = 'All My Open Assigned Tickets';
            $scopes["on_hold_assigned_to_me"] = 'All My On-Hold Assigned Tickets';
            $scopes["pending_assigned_to_me"] = 'All My Pending Assigned Tickets';
            $scopes["completed_assigned_to_me"] = 'All My Completed Assigned Tickets';
            $scopes["open_tasks_assigned_to_me"] = 'All My Open Assigned Tasks';
            $scopes["on_hold_tasks_assigned_to_me"] = 'All My On-Hold Assigned Tasks';
            $scopes["pending_tasks_assigned_to_me"] = 'All My Pending Assigned Tasks';
            $scopes["completed_tasks_assigned_to_me"] = 'All My Completed Assigned Tasks';
            $scopes["all_mine_tasks"] = 'All My Assigned Tasks';
            $scopes["due_by_today"] = 'All Tickets due by today';
            $scopes["my_over_due"] = 'All My Overdue Tickets';
            $scopes["over_due"] = 'All Overdue Tickets';
            $scopes["in_my_groups"] = 'All Tickets';
        }

        return $scopes;
    }

    public function apply($scope)
    {
        if (method_exists($this, $scope)) {
            if (in_array($scope, self::$statusScopes)) {
                $this->in_my_groups();
            }

            call_user_func([$this, $scope]);
        } else {
            $this->my_pending();
        }
    }

    public function all_mine()
    {
        $this->mine_with_approvals();
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

    public function open_tasks_assigned_to_me()
    {
        $this->open_mine_tasks();
    }

    public function on_hold_tasks_assigned_to_me()
    {
        $this->on_hold_mine_tasks();
    }

    public function pending_tasks_assigned_to_me()
    {
        $this->pending_mine_tasks();
    }

    public function completed_tasks_assigned_to_me()
    {
        $this->completed_mine_tasks();
    }

    public function all_mine_tasks()
    {
        $this->mine_tasks();
    }

    public function mine()
    {
        $this->query->where(function (Builder $q) {
            $q->where('technician_id', $this->user->id)
                ->orWhere('requester_id', $this->user->id)
                ->orWhere('coordinator_id', $this->user->id);
        });
    }

    public function mine_with_approvals()
    {
        $this->query->where(function (Builder $q) {
            $q->where('technician_id', $this->user->id)
                ->orWhere('requester_id', $this->user->id)
                ->orWhere('coordinator_id', $this->user->id)
                ->orwhereHas('approvals', function (Builder $q) {
                    $q->where('approver_id', \Auth::user()->id)
                        ->where('status', TicketApproval::PENDING_APPROVAL);
                });
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
        if (!auth()->user()->isAdmin()) {
            $this->query->whereIn('group_id', $this->user->groups->pluck('id')->toArray());
        }
    }

    public function pending()
    {
        $this->query->pending();
    }

    public function open()
    {
        $this->query->whereHas('status', function (Builder $q) {
            $q->where('type', Status::OPEN);
        });
    }

    public function completed()
    {
        $this->query->whereHas('status', function (Builder $q) {
            $q->where('type', Status::COMPLETE);
        });
    }


    public function on_hold()
    {
        $this->query->whereHas('status', function (Builder $q) {
            $q->where('type', Status::PENDING);
        });
    }

    public function for_approval()
    {
        $this->query->whereHas('approvals', function (Builder $q) {
            $q->where('approver_id', \Auth::user()->id)
                ->where('status', TicketApproval::PENDING_APPROVAL);
        });
    }

    public function open_assigned()
    {
        $this->query->where('technician_id', $this->user->id)
            ->where('status_id', 1);
    }

    public function onHoldAssigned()
    {
        $this->query->where('technician_id', $this->user->id)
            ->whereIn('status_id', [4, 5, 6]);
    }

    public function completedAssigned()
    {
        $this->query->where('technician_id', $this->user->id)
            ->whereIn('status_id', [7, 8, 9]);
    }

    public function open_assigned_to_me()
    {
        $this->open_assigned();
    }

    public function on_hold_assigned_to_me()
    {
        $this->onHoldAssigned();
    }

    public function completed_assigned_to_me()
    {
        $this->completedAssigned();
    }

    function due_by_today()
    {
        $this->dueByToday();
    }

    function my_over_due()
    {
        $this->overdue();
    }

    function over_due()
    {
        $this->allOverdue();
    }

    function pending_assigned_to_me()
    {
        $this->pendingAssigned();
    }

    public function dueByToday()
    {
        $this->query->where('due_date', '>', Carbon::today()->format('Y-m-d') . ' 00:00:00.000000')
            ->where('due_date', '<', Carbon::today()->format('Y-m-d') . ' 23:59:59.000000')
            ->where('technician_id', $this->user->id)
            ->whereNotIn('status_id', [7, 8, 9]);
    }

    public function overdue()
    {
        $this->query->where('overdue', 1)->where('technician_id', $this->user->id)->whereNotIn('status_id', [7, 8, 9]);
    }

    public function allOverdue()
    {
        $this->in_my_groups();
        $this->query->where('overdue', 1)->whereNotIn('status_id', [7, 8, 9]);
    }

    public function pendingAssigned()
    {
        $this->query->whereNotIn('status_id', [7, 8, 9])->where('technician_id', $this->user->id);
    }

    public function open_mine_tasks()
    {
        $this->query->where(function (Builder $q) {
            $q->where('technician_id', $this->user->id)->where('type', 2)->where('status_id', 1);
        });

    }

    public function on_hold_mine_tasks()
    {
        $this->query->where(function (Builder $q) {
            $q->where('technician_id', $this->user->id)->where('type', 2)->whereIn('status_id', [4, 5, 6]);
        });
    }

    public function pending_mine_tasks()
    {
        $this->query->whereNotIn('status_id', [7, 8, 9])->where('technician_id', $this->user->id)->where('type', 2);
    }

    public function completed_mine_tasks()
    {
        $this->query->where('technician_id', $this->user->id)->whereIn('status_id', [7, 8, 9])->where('type', 2);
    }

    public function mine_tasks()
    {
        $this->query->where('technician_id', $this->user->id)->where('type', 2);
    }
}