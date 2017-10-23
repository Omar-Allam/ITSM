<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/15/17
 * Time: 11:30 AM
 */

namespace App\Policies;


use App\Ticket;
use App\User;

trait TicketTrait
{
    function ticket_read(User $user, Ticket $ticket)
    {
        $privileged = [$ticket->requester_id, $ticket->technician_id, $ticket->coordinator_id];

        return in_array($user->id, $privileged) ||
            $user->groups->contains($ticket->group_id) ||
            $ticket->approvals()->pluck('approver_id')->contains($user->id) || $user->isTechnicainSupervisor($ticket);
    }

    public function ticket_create(User $user, Ticket $task)
    {
        return $user->isTechnician();
    }

    function ticket_close(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->requester_id;
    }
}