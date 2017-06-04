<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    function read(User $user, Ticket $ticket)
    {
        $privileged = [$ticket->requester_id, $ticket->technician_id, $ticket->coordinator_id];

        return in_array($user->id, $privileged) ||
            $user->groups->contains($ticket->group_id) ||
            $ticket->approvals()->pluck('approver_id')->contains($user->id);
    }

    function modify(User $user, Ticket $ticket)
    {
        return in_array($user->id, [$ticket->technician_id, $ticket->coordinator_id]) ||
            $user->groups->contains($user->id);
    }

    function resolve(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->technician_id;
    }

    function reply(User $user, Ticket $ticket)
    {
        $privileged = [$ticket->requester_id, $ticket->technician_id, $ticket->coordinator_id];

        return in_array($user->id, $privileged) ||
            $user->groups->contains($ticket->group_id);
    }

    function close(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->requester_id;
    }

    function delete(User $user, Ticket $ticket)
    {
        return false;
    }


}
