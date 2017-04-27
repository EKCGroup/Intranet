<?php defined('C5_EXECUTE') or die('Access Denied.');

if (isset($error)) {
    echo $error.'<br/><br/>';
}

if (!isset($query) || !is_string($query)) {
    $query = '';
}

?>
<form action="<?php echo $view->url($resultTargetURL)?>" method="get" class="ccm-search-block-form">
    <?php
        if (isset($title) && ($title !== '')) {
        }
        if ($query === '') { ?>
            <button name="submit" type="submit" class="btn btn-default ccm-search-block-submit search-site" /><i class="fa fa-search fa-flip-horizontal fa-lg"></i></button>
        <?php } ?>
            <input name="query" type="text" autocomplete="off" placeholder="<?php echo ($title)?>" class="ccm-search-block-text search-site" />
        <?php if (isset($buttonText) && ($buttonText !== '')) {
        }
    ?>
</form>
