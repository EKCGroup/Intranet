<?php defined('C5_EXECUTE') or defined('BASEPATH') or die("Access Denied."); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Intranet - Canterbury College</title>
        <link rel="stylesheet" type="text/css" href="/application/themes/ccintranet/assets/css/minify-login-style.css" /> <!-- Desktop and Mobile Style (Minus Responsive Footer) -->
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 651px)" href="/application/themes/ccintranet/assets/css/minify-login-style-dfooter.css" /> <!-- Desktop Style -->
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 650px)" href="/application/themes/ccintranet/assets/css/minify-login-style-mfooter.css" /> <!-- Mobile Style -->
        <meta name="keywords" content="Canterbury, College, Cantebury College, Login, Office 365, VLE, e-Tracker, Learning Curve, Intranet, BKSB">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
        <meta name="description" content="Welcome to the Canterbury College.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name="author" content="Canterbury College">
    	<meta name="theme-color" content="#005393">
        <meta charset="utf-8">
        <?php if (!isset($is_codeigniter)) { ?>
            
            <?php Loader::element('header_required'); ?>
        
        <?php /* END Codeigniter */ } ?>
    </head>    
    <body>
        <div class="custom-login-panel">
            <div class="login-panel">
                <header>
                    <a href="https://canterburycollege.ac.uk/">
                        <h1>Canterbury College</h1>
                    </a>
                </header>
                <div class="login-panel-main">
                    <main>
                        
                        <?php if (isset($is_codeigniter)) { ?>
                        
                            <?= $ci_content; ?>

                        <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
			
                            <!-- Print Page Content -->
                            <?php print $innerContent; ?>

                            <!-- Login Error Reporting -->
                            <?php Loader::element('system_errors', array('error' => $error)); ?>

                        <?php /* END Concrete5*/ } ?>
                            
                    </main>
                    <nav>
                        <button class="button-off" id="top-button" onclick="location.href='https://vle.cant-col.ac.uk'">VLE Login</button>
                        <button class="button-off" onclick="location.href='https://login.microsoftonline.com/'">Office 365</button>
                        <button class="button-off" onclick="location.href='https://rems.canterburycollege.ac.uk/portal/html/HOM/portalhome.htm#Home'">REMs</button>
                        <button class="button-off" onclick="location.href='https://etracker.cant-col.ac.uk/'">e-Trackr</button>
                        <button class="button-on" onclick="location.href='http://intranet.cant-col.ac.uk'">Intranet</button>
                        <button class="button-off" onclick="location.href='https://mail.cant-col.ac.uk'">Staff Outlook</button>
                        <button class="button-off" id="bottom-button" onclick="location.href='https://www.bksblive.co.uk/bksblive1/CanterburyCollege/default.aspx'">BKSB</button>
                        <a href="https://canterburycollege.ac.uk/"><img src="https://login.cant-col.ac.uk/logo.png" height="30"></a>
                    </nav>
                </div><!--end div class=login-panel-main-->
            </div><!--end div class=login-panel-->
            <footer>
                <p class="copy">&copy; Copyright <?= date("Y") ?> by Canterbury College</p>
            </footer>
        </div><!--end div class=custom-login-panel-->  
            
        <style> body { visibility: visible !important;} </style> 
        <?php if (!isset($is_codeigniter)) { ?>
            
            <?php Loader::element('footer_required'); ?>
        
        <?php /* END Codeigniter */ } ?>
    </body>
</html>
