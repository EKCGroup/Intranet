<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$ci_content = '
    
    <h2>404 | Page not Found.</h2>
    <p>This page may have been moved or deleted.</p><br>
    <p onclick="goBack()">Go Back</p>
        <script>
            function goBack() { window.history.back(); }
        </script>
        
';

$is_codeigniter = 1;
include('/var/www/html/intranet/application/elements/login.php');

?>