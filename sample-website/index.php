<?php

require_once __DIR__ . '/Forum.php';

$users = [
    'user' => [
        'password' => 'password',
        'email' => 'user@example.com',
    ],
    'admin' => [
        'password' => 'password',
        'email' => 'user1@example.com',
    ],
];

$username = empty($_POST['username']) ? '' : $_POST['username'];
$password = empty($_POST['password']) ? '' : $_POST['password'];

if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $email = $users[$username]['email'];
    $forum = new Forum();
    $forum->login($username, $email);
    $forum->redirectToForum();
} elseif (!empty($username) || !empty($password)) {
    echo 'Login failed';
}
?>

<h1>Login</h1>

<p><?= array_keys($users)[0] ?> / <?= $users['user']['password'] ?></p>
<p><?= array_keys($users)[1] ?> / <?= $users['admin']['password'] ?></p>

<form method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>
