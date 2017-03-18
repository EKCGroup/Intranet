<?php defined('C5_EXECUTE') or die("Access Denied."); ?>            

<?php Loader::element('header'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-8 staff-bulletin">
                    <h1 class="page-header"><?php $page = Page::getCurrentPage(); echo $page->getCollectionName(); ?></h1>
                    <br>
                    <?php $a= new Area('Page Content'); $a->display($c); ?>
                </div> <!-- END col-lg-8 -->
                <div class="col-lg-4 content-box">
                    <div class="content-box">
                        <div id="content-box" class="well content-box-button-1">
                            <div id="content-box-title-block" class="content-box-title-block-1">
                                <?php $a= new Area('Department 1 Title'); $a->display($c); ?>
                            </div> <!-- END content-box-title-block-1 -->
                            <div class="content-box-content">
                                <?php $a= new Area('Department 1 Content'); $a->display($c); ?>
                            </div> <!-- END content-box-content -->
                        </div> <!-- END content-box-button-1 -->
                        <div id="content-box" class="well content-box-button-2">
                            <div id="content-box-title-block" class="content-box-title-block-2">
                                <?php $a= new Area('Department 2 Title'); $a->display($c); ?>
                            </div> <!-- END content-box-title-block-2 -->
                            <div class="content-box-content">
                                <?php $a= new Area('Department 2 Content'); $a->display($c); ?>
                            </div> <!-- END content-box-content -->
                        </div> <!-- END content-box-button-2 -->
                        <div id="content-box" class="well content-box-button-4">
                            <div id="content-box-title-block" class="content-box-title-block-4">
                                <?php $a= new Area('Department 3 Title'); $a->display($c); ?>
                            </div> <!-- END content-box-title-block-4 -->
                            <div class="content-box-content">
                                <?php $a= new Area('Department 3 Content'); $a->display($c); ?>
                            </div> <!-- END content-box-content -->
                        </div> <!-- END content-box-button-4 -->
                        <div id="content-box" class="well content-box-button-4">
                            <div id="content-box-title-block" class="content-box-title-block-4">
                                <?php $a= new Area('Department 4 Title'); $a->display($c); ?>
                            </div> <!-- END content-box-title-block-4 -->
                            <div class="content-box-content">
                                <?php $a= new Area('Department 4 Content'); $a->display($c); ?>
                            </div> <!-- END content-box-content -->
                        </div> <!-- END content-box-button-4 -->
                        <div id="content-box" class="well content-box-button-5">
                            <div id="content-box-title-block" class="content-box-title-block-5">
                                <?php $a= new Area('Department 5 Title'); $a->display($c); ?>
                            </div> <!-- END content-box-title-block-1 -->
                            <div class="content-box-content">
                                <?php $a= new Area('Department 5 Content'); $a->display($c); ?>
                            </div> <!-- END content-box-content -->
                        </div> <!-- END content-box-button-1 -->
                    </div> <!-- END content-box -->
                </div> <!-- END col-md-12 -->
            </div> <!-- END col-md-12 -->
        </div> <!-- END row -->
    </div> <!-- END container-fluid -->
<?php Loader::element('footer');