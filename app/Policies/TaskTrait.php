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
        return $user->id == $task->ticket->technicain_id || $user->isTechnician();
    }


    public function task_create(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technicain_id;
    }


    public function task_modify(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technician_id;
    }

    public function task_resolve(User $user, Ticket $task)
    {
        return $user->id == $task->technician_id;
    }

    public function task_close($user, $task)
    {
        return $user->id == $task->ticket->technician_id;
    }

    public function task_delete(User $user, Ticket $task)
    {
        return $user->id == $task->ticket->technician_id;
    }

}