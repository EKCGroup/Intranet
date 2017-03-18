<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php if (isset($_COOKIE['CI-CONCRETE5'])) {
            $this->load->view('templates/toolbars/marketing/visitor.php'); 
        } ?>
        <div class="col-lg-12">
            <h1 class="page-header">Posted Successfully</h1>
            <p>Form posted successfully</p>
            <meta http-equiv="refresh" content="1; URL='<?= base_url('marketing/visitor'); ?>'" />
            <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i> Redirecting...
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

