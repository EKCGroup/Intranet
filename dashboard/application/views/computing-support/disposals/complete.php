<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/disposals.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Disposals Complete</h1>
            <p>All current disposals have been completed</p>
            <meta http-equiv="refresh" content="1; URL='/dashboard/computing-support/disposals/history'" />
            <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> Redirecting...
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

