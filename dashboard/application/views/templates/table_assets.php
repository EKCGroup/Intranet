<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?= $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
    <script src="<?= $file; ?>"></script>
<?php endforeach; ?>