<?php defined('C5_EXECUTE') or die("Access Denied.");

$navItems = $controller->getNavItems(true); // Ignore exclude from nav
$c = Page::getCurrentPage();

if (count($navItems) > 0) {
    
        echo '<i class="fa fa-home fa-lg" aria-hidden="true"></i>';
	echo '<span role="navigation" aria-label="breadcrumb">';
    
        foreach ($navItems as $ni) {
            if ($ni->isCurrent) {
                echo '<a>' . $ni->name . '</a>';
            } else {
                echo '<a href="' . $ni->url . '" target="' . $ni->target . '">' . $ni->name . '</a> / ';
            }
        }
    
}