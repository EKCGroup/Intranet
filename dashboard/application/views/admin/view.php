<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>  
        <div class="col-lg-12">
            <h1 class="page-header">Admin</h1>

            <p><b>Online Forms</b></p>

            <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/user/intranet'); ?>">Intranet Users</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/user/dashboard'); ?>">Dashboard Users</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/user/passkey'); ?>">Passkeys</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('admin/jobs-logs'); ?>">Jobs & Logs</a>
                        <td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->