<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/room_move.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Room Move Request Complete</h1>
            <p>An email has been sent to the members of staff featuring in this request.</p>
            <p>The request must also be approved by Estates and Computing Support. You will be notified on the progress.</p>
            <a href="/dashboard/computing-support/room-move/check">View Request</a> <br>
            <a href="/dashboard/computing-support">Back to Computing Support Dashboard</a>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

