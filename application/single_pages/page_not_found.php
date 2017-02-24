<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<h2>404 | Page not Found.</h2>
<p>This page may have been moved or deleted.</p>
<br/>
<p onclick="goBack()">Go Back</p>
<script>
    function goBack() {
        window.history.back();
    }
</script>