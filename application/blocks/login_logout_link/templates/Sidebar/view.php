<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <li><a href="<?php echo $url; ?>"><span><?php echo h($label) ?><span><i class="
        <?php
            global $u;
            if ($u->isLoggedIn()) {
                echo 'fa fa-sign-out fa-lg';
            } else {
                echo 'fa fa-sign-in fa-lg';
            }
        ?>
    "></i></a></li>