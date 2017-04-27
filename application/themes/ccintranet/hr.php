<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php Loader::element('header'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="toolbar"><?php $a= new GlobalArea('HR Toolbar'); $a->display($c); ?></div>
            <div class="col-lg-12">
                <h1 class="page-header"><?php $page = Page::getCurrentPage(); echo $page->getCollectionName(); ?></h1>
                <br>
                <?php $a= new Area('Page Content'); $a->display($c); ?>
            </div> <!-- END col-lg-12 -->
        </div> <!-- END row -->
    </div> <!-- END container-fluid -->
<?php Loader::element('footer');