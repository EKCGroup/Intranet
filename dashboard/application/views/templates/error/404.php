<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/header.php'); ?>
    
    <h2>404 | Page not Found.</h2>
    <p>This page may have been moved or deleted.</p><br>
    <p onclick="goBack()">Go Back</p>
        <script>
            function goBack() { window.history.back(); }
        </script>
        
<?php include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/footer.php');
