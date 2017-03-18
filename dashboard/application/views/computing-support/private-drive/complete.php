<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/private-drive.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Private Drive Request Complete</h1>
            <p>Access requested</p>
            <meta http-equiv="refresh" content="1; URL='/dashboard/computing-support/private-drive/check'" />
            <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> Redirecting...
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

