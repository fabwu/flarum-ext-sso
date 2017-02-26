<?php

require_once __DIR__ . '/Forum.php';

Forum::logout();

if ($_GET['forum']) {
    Forum::redirectToForum();
}
