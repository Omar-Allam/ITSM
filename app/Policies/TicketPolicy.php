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

    function reply(User $user, Ticket $ticket)
    {
        $privileged = [$ticket->requester_id, $ticket->technician_id, $ticket->coordinator_id];

        return in_array($user->id, $privileged) ||
            $user->groups->contains($ticket->group_id) || $user->isTechnician();
    }

    function delete(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->technician_id;
    }

    function resolve(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->technician_id || $user->isTechnicainSupervisor($ticket);
    }

    function pick(User $user, Ticket $ticket)
    {
        if (($user->hasGroup($ticket->group) && $user->id != $ticket->technician_id)) {
            return true;
        }

        return false;
    }

    function show_approvals(User $user , Ticket $ticket){
        return $user->isSupport();
    }

    public function modify(User $user , Ticket $task){
        return $user->id == $task->technician_id || $user->isTechnicainSupervisor($task);
    }

}
