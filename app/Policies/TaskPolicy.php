<?php

namespace App\Policies;

use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given task can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }


    /**
     * Determine if the given task can be viewed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return bool
     */
    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
