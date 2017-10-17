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

    protected $map = [1 => 'ticket', 2 => 'task'];

    function __call($name, $args)
    {
        $ticket = $args[1];
        $prefix = $this->map[$ticket->type] ?? '';
        if (!$prefix) {
            return false;
        }
        
        $ability = $prefix . '_' . $name;

        if (method_exists($this, $ability)) {
            return $this->$ability(...$args);
        }

        return false;
    }

    /*function read(User $user, Ticket $ticket)
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

    

     */

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
            $user->groups->contains($ticket->group_id) || $user->isTechnician();
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
