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
            $ticket->approvals()->pluck('approver_id')->contains($user->id);
    }

    function ticket_modify(User $user, Ticket $ticket)
    {

        return in_array($user->id, [$ticket->technician_id, $ticket->coordinator_id]) ||
            $user->groups->contains($ticket->group_id);
    }

    function ticket_resolve(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->technician_id;
    }

    function ticket_close(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->requester_id;
    }
}