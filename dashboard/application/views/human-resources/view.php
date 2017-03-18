<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Human Resources Dashboard</h1>

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
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="/cc/staff-portal/human-resources"> Go to the Intranet</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="http://sap06-70/accessselecthr182/"> SelectHR</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="https://cancoli.webitrent.com/cancoli_ess/"> Payroll</a>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="http://appraisal.cant-col.ac.uk/"> Appraisal</a>
                        <td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table> <br>

            <?php
            if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                    in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
                ?>

                <p><b>HR Forms</b></p>

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
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/new-account'); ?>">New Staff Account</a>
                                - <a href="<?= base_url('/computing-support/new-account/pending');?>">Pending</a>
                                - <a href="<?= base_url('/computing-support/new-account/history'); ?>">History</a>
                                    <td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/new-account/disable-account'); ?>">Disable Staff Account</a>
                                        - <a href="<?= base_url('/computing-support/new-account/disable-account/pending');?>">Pending</a>
                                        - <a href="<?= base_url('/computing-support/new-account/disable-account/history'); ?>">History</a>
                                    </td>
                                    <td></td><td></td><td></td>
                                </tr>
                            </tbody>
                        </table> <br>

        <?php } ?>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->