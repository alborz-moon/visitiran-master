<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Launcher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LauncherPolicy
{
    use HandlesAuthorization;

    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before(User $user, $ability)
    {
        return true;
        // return $user->level === User::$ADMIN_LEVEL || $user->level === User::$EDITOR_LEVEL;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Launcher $launcher) {
        return $launcher->user_id == $user->id || 
            $user->level == User::$ADMIN_LEVEL || 
            $user->level == User::$EDITOR_LEVEL
        ;
    }
    
    public function show(User $user, Launcher $launcher) {
        dd("wq");
        return $launcher->status == Event::$CONFIRMED_STATUS;
    }

    //todo : complete section
}
