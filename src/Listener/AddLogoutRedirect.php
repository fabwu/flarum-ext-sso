<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\Event\UserLoggedOut;
use Illuminate\Contracts\Events\Dispatcher;

class AddLogoutRedirect
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserLoggedOut::class, [$this, 'addLogoutRedirect']);
    }

    public function addLogoutRedirect()
    {
        $url = 'https://lanport.ch/logout?forum=1';

        header('Location: ' . $url);
        die();
    }
}
