<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/header.php'); ?>
    
    <h2>Permission Denied.</h2>
    <p>You do not have privileges to view this page.</p><br>
    <p onclick="goBack()">Go Back</p>
        <script>
            function goBack() { window.history.back(); }
        </script>
        
<?php include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/layout/footer.php');
