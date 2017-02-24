<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-panel-content-inner">

    <?php if ($canViewSitemap) { ?>
        <h5><?php echo t('Sitemap') ?></h5>
        <div id="ccm-sitemap-panel-sitemap"></div>
        <script type="text/javascript">
            $(function () {
                $('#ccm-sitemap-panel-sitemap').concreteSitemap({
                    onClickNode: function (node) {
                        window.location.href = CCM_DISPATCHER_FILENAME + '?cID=' + node.data.cID;
                    }
                });
            });
        </script>
    <?php } ?>

    <h5>Links</h5>
    <a href="/index.php/dashboard/sitemap/full">Sitemap</a><br>
    <a href="/index.php/dashboard/files/search">File Manager</a>


</div>
