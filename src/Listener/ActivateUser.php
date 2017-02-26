<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\Event\UserWasRegistered;
use Illuminate\Contracts\Events\Dispatcher;

class ActivateUser
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserWasRegistered::class, [$this, 'activateUser']);
    }

    public function activateUser(UserWasRegistered $event)
    {
        $user = $event->user;
        $user->activate();
        $user->save();
    }
}
