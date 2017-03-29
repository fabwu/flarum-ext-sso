<?php
/*
Plugin Name: Flarum Single Sign On
*/

require_once __DIR__ . '/Forum.php';

$flarum = new Forum();

function flarum_sso_login_redirect($redirect_to, $request, $user)
{
    global $flarum;

    if ($redirect_to === 'forum' && $user instanceof WP_User) {
        $flarum->redirectToForum();
    }

    return $redirect_to;
}

add_filter('login_redirect', 'flarum_sso_login_redirect', 10, 3);

function flarum_sso_login($user_login, $user)
{
    global $flarum;

    $flarum->login($user->user_login, $user->user_email);
}

add_action('wp_login', 'flarum_sso_login', 10, 2);

function flarum_sso_logout()
{
    global $flarum;

    $flarum->logout();
}

add_action('wp_logout', 'flarum_sso_logout');
