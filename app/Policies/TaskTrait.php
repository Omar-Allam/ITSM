<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/15/17
 * Time: 10:24 AM
 */

namespace App\Policies;


use App\Ticket;
use App\User;

trait TaskTrait
{
    public function task_read(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technicain_id ||
            $user->groups->contains($task->ticket->group_id) ||
            $task->technicain_id || $user->isTechnicainSupervisor($task->ticket);
    }

    public function task_create(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technicain_id || $user->isTechnicainSupervisor($task->ticket);
    }

    public function task_close(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technician_id || $user->isTechnicainSupervisor($task->ticket);
    }


}