<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\Event\UserLoggedOut;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class AddLogoutRedirect
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserLoggedOut::class, [$this, 'addLogoutRedirect']);
    }

    public function addLogoutRedirect()
    {
        $url = $this->settings->get('wuethrich44-sso.logout_url');

        header('Location: ' . $url);
        die();
    }
}
