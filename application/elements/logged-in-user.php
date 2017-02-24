<?php

function ip_is_private() {
    $pri_addrs = array(
        '10.0.0.0|10.255.255.255',
    );

    $long_ip = ip2long($_SERVER['REMOTE_ADDR']);
    if ($long_ip != -1) {
        foreach ($pri_addrs AS $pri_addr) {
            list ($start, $end) = explode('|', $pri_addr);

            // IF IS PRIVATE
            if ($long_ip >= ip2long($start) && $long_ip <= ip2long($end)) {
                return true;
            }
        }
    }
    return false;
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
?>