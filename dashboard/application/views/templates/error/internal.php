<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/header.php'); ?>
    
    <h2>Internal Access Only.</h2>
    <p>This page has been restriced to internal use only.</p><br>
    <p onclick="goBack()">Go Back</p>
        <script>
            function goBack() { window.history.back(); }
        </script>
        
<?php include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/footer.php');