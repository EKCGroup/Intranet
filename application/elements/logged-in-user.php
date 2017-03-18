<?php

function ip_is_private() {
    $safe_ip = array(
        '194.82.168.3', //Canterbury
        '194.82.171.2', //Sheppey
        '195.194.248.2', //Broadstairs
        '212.219.171.98', //Dover
        '195.194.250.2', //Folkstone
    );

    if (in_array($_SERVER['REMOTE_ADDR'], $safe_ip)) {
        return true;
    } else {
        return false;
    }
}

$u = new User();
global $u;

if ($u->isLoggedIn()) {
    echo '<p class="welcome-username">Welcome ' . $u->getUserName() . '</p>';
} else {
    echo '<p class="welcome-username"><a href="/login">Click here to Login</a></p>';

    $page = Page::getCurrentPage();

    if ($page->getCollectionName() == 'Home') {

        $ip = $_SERVER['REMOTE_ADDR'];
        if (ip_is_private() === FALSE) {
            header('Location: /login');
            die();
        }
    }
}
if ($u->inGroup(Group::getByName('Students'))) {
    header('Location: /dashboard/permissions');
    die();
}
