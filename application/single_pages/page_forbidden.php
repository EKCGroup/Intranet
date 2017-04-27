<?php defined('C5_EXECUTE') or die("Access Denied.");

    $u = new User();
    if ($u->inGroup(Group::getByName('Students'))) {
?>
    <h2>403 | Permission Denied.</h2>
    <p>Staff only Platform; please use the VLE</p>
    <br/>
    <br/>
    <a href="https://vle.cant-col.ac.uk/login/index.php">Go to the VLE</a>.

<?php } else { ?>
    
    <h2>403 | Permission Denied.</h2>
    <p>You do not have permission to access this page.</p>
    <br/>
    <p onclick="goBack()">Go Back</p>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

<?php }
