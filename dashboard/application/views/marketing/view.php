<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Marketing Dashboard</h1>
            
            <p><b>Online Forms</b></p>
            
            <table id="datatable" class="table table-striped sortable">
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
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="/cc/staff-portal/marketing"> Go to the Intranet</a>
                            <td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table> <br>
            
            <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                      in_array('CN=Intranet_Edit_Marketing,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            
            <p><b>Marketing Forms</b></p>
                
                <table id="datatable" class="table table-striped sortable">
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
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('marketing/visitor');?>">Open Day Visitor Form</a>
                                - <a href="<?= base_url('marketing/visitor/history');?>">History</a>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="http://rems2web.cant-col.ac.uk/">Rems2Web</a>
                            <td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table> <br>
            
            <?php } ?>
            
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->