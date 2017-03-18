<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/temporary_account.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Temporary Account Error</h1>
            <p>Error creating account for <?= $_GET['id'] ?>.</p>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

