<?php defined('C5_EXECUTE') or die("Access Denied.");

$is_concrete5 = TRUE; ?>

<!-- Jquery Order Matters -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>

<?php Loader::element('header_required');

include('/var/www/html/intranet/application/elements/theme/global/ResponsiveLoginDesign/concrete5.php');

Loader::element('footer_required');