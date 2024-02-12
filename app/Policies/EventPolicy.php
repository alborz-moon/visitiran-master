<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    // /**
    //  * Create a new policy instance.
    //  *
    //  * @return void
    //  */
    public function before(User $user, $ability)
    {
        return true;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function update(User $user, Event $event) {
        
        $launcher = $user->launcher;
        if($launcher == null)
            return false;

        return $event->launcher_id === $launcher->id;
    }
    
    public function destroy(User $user, Event $event) {
        
        $launcher = $user->launcher;
        if($launcher == null)
            return false;

        return $event->launcher_id === $launcher->id;
    }

    public function getPhaseInfo(User $user, Event $event) {
        $launcher = $user->launcher;
        if($launcher == null)
            return false;

        return $event->launcher_id === $launcher->id;
    }
}
