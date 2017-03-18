<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$ci_content = '
    
    <h2>Job Run.</h2>
    <p>This job has been run.</p><br>
    <p onclick="goBack()">Go Back</p>
        <script>
            function goBack() { window.history.back(); }
        </script>
        
';

$is_codeigniter = 1;
include('/var/www/html/intranet/application/elements/login.php');

?>