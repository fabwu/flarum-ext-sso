<?php

use Illuminate\Contracts\Events\Dispatcher;
use Wuethrich44\SSO\Listener;

return function (Dispatcher $events) {
    $events->subscribe(Listener\AddClientAssets::class);
    $events->subscribe(Listener\AddLogoutRedirect::class);
    $events->subscribe(Listener\ActivateUser::class);
    $events->subscribe(Listener\LoadSettingsFromDatabase::class);
};
