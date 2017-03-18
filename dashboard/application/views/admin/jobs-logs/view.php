<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>  
        <div class="col-lg-12">
            <h1 class="page-header">Jobs & Logs</h1>

            <h1 style="font-size: 14px;"><b>All Logs</b></h1>

            <table class="table table-striped online-form" style="font-weight: normal;">
                <thead>
                    <tr>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="50%">Name</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="150px">Size</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="100px">Upload Date</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;">Download</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/jobs-logs/intranet'); ?>">Intranet Logs</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/jobs-logs/dashboard'); ?>">Dashboard Logs</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/jobs-logs/passkey'); ?>">Passkeys Logs</a>
                        <td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>
            
            <h1 style="font-size: 14px;"><b>All Jobs</b></h1>
            
            <table class="table table-striped online-form" style="font-weight: normal;">
                <thead>
                    <tr>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="50%">Name</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="150px">Size</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;" width="100px">Upload Date</th>
                        <th style="font-size: 12px;font-weight: normal;opacity: 0.8;">Download</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/jobs-logs/ad-user-sync'); ?>">AD User Sync</a>
                            - <a href="<?= base_url('core/jobs/ad-users-sync');?>">Run Now</a>
                        <td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->