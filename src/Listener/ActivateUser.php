<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\User\Event\Registered;
use Illuminate\Contracts\Events\Dispatcher;

class ActivateUser
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Registered::class, [$this, 'activateUser']);
    }

    public function activateUser(Registered $event)
    {
        $user = $event->user;
        $user->activate();
        $user->save();
    }
}
