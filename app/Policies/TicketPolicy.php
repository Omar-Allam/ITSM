<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;
    use TaskTrait;
    use TicketTrait;

    function read(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_read($user, $ticket);
        } else {
            $this->ticket_read($user, $ticket);
        }

    }

    function create(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_create($user, $ticket);
        }

    }

    function modify(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_modify($user, $ticket);
        } else {
            $this->ticket_modify($user, $ticket);
        }
    }

    function resolve(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_resolve($user, $ticket);
        } else {
            $this->ticket_resolve($user, $ticket);
        }
    }

    function reply(User $user, Ticket $ticket)
    {
        $privileged = [$ticket->requester_id, $ticket->technician_id, $ticket->coordinator_id];

        return in_array($user->id, $privileged) ||
            $user->groups->contains($ticket->group_id);
    }

    function close(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_close($user, $ticket);
        }
        else{
            $this->ticket_close($user, $ticket);
        }
    }

    function delete(User $user, Ticket $ticket)
    {
        if ($ticket->type == 2) {
            $this->task_delete($user, $ticket);
        } else {
            return false;
        }
    }

    function pick(User $user, Ticket $ticket)
    {
        if (($user->hasGroup($ticket->group) && $user->id != $ticket->technician_id)) {
            return true;
        }

        return false;
    }


}
