<?php
/*
Plugin Name: Flarum Single Sign On
*/

require_once __DIR__ . '/Forum.php';

function my_login_redirect($redirect_to, $request, $user)
{
    if ($redirect_to === 'forum' && $user instanceof WP_User) {
        $forum = new Forum();
        $forum->redirectToForum();
    }

    return $redirect_to;
}

add_filter('login_redirect', 'my_login_redirect', 10, 3);

function login($user_login, $user)
{
    $forum = new Forum();
    $forum->login($user->user_login, $user->user_email);
}

add_action('wp_login', 'login', 10, 2);
