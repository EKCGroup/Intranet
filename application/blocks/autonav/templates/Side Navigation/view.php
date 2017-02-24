<?php defined('C5_EXECUTE') or die("Access Denied.");

$navItems = $controller->getNavItems();
$c = Page::getCurrentPage();


if (count($navItems) > 0) { ?>

    <?php foreach ($navItems as $ni) {
        
        echo '<li>'; 
        echo '<a href="' . ($ni->level = 1 && $ni->hasSubmenu ? '#' : $ni->url) . '" class="' . ($ni->level = 1 && $ni->hasSubmenu ? 'submenu-button' : $ni->classes) . '">';
       
        echo $ni->name;

        if ($ni->hasSubmenu) {
            echo '<span style="margin-top: -5px;" class="fa arrow fa-lg"></span>';
            echo '<ul class="nav nav-second-level collapse">';
        } else {
            echo '</li></a>';
            echo str_repeat('</ul>', $ni->subDepth);
        }
    } 
} ?>
