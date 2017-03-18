<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/welcome.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Computing Support Dashboard</h1>
            
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
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="/cc/staff-portal/computing-support/log-job">Log a Job</a></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/status');?>">Service Status</a></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="https://dashboard.cant-col.ac.uk/index.php/student_pw_reset/create/index.php">Student Account Reset</a></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="https://dashboard.cant-col.ac.uk/index.php/home/temp_account/create">Temporary Computer Account</a>
                            - <a href="https://dashboard.cant-col.ac.uk/index.php/home/temp_account/status">Check Status</a>
                            <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="https://dashboard.cant-col.ac.uk/index.php/home/temp_account/cs_approve">Approve</a>
                            <?php } ?></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <?php if ($_SESSION['username'] == 'wbargent') { ?>
                    <?php if (in_array('CN=Dashboard_Temporary_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                              in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/temporary-account')?>">Temporary Computer Account</a>
                                - <a href="<?= base_url('computing-support/temporary-account/check')?>">Check Status</a>
                                <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                    - <a href="<?= base_url('computing-support/temporary-account/pending')?>">Pending</a>
                                    - <a href="<?= base_url('computing-support/temporary-account/history')?>">History</a>
                                <?php } ?></td>
                            <td></td><td></td><td></td>
                        </tr> 
                    <?php }} ?>
                    <tr>
                        <?php if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                                  in_array('CN=Dashboard_Section_Manager,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                                  in_array('CN=Dashboard_Faculty_Head,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/private-drive')?>">Private Folder Access</a>
                                - <a href="<?= base_url('computing-support/private-drive/check')?>">Check</a>
                                <?php if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="<?= base_url('computing-support/private-drive/pending')?>">Pending</a>
                                <?php } 
                                if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="<?= base_url('computing-support/private-drive/history')?>">History</a>
                                <?php } ?>
                            </td>
                        <?php } else { ?>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/private-drive/check')?>">Private Folder Access Status</a>
                            </td>
                        <?php } ?>
                        <td></td><td></td><td></td>
                    </tr>
                    <?php if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                              in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                              in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/new-account');?>">New Staff Account</a>
                                - <a href="<?= base_url('/computing-support/new-account/pending');?>">Pending</a>
                                - <a href="<?= base_url('/computing-support/new-account/history');?>">History</a>
                                <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                    - <a href="<?= base_url('/computing-support/new-account/export');?>">Export New Staff</a>
                                <?php } ?>
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                    <?php } ?>
                    <?php if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                              in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                              in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/new-account/disable-account');?>">Disable Staff Account</a>
                                - <a href="<?= base_url('/computing-support/new-account/disable-account/pending');?>">Pending</a>
                                - <a href="<?= base_url('/computing-support/new-account/disable-account/history');?>">History</a>
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/address-book');?>">Address Book Update</a>
                            <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="<?= base_url('computing-support/address-book/history');?>">History</a>
                            <?php } ?>
                        </td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/mobile-policy');?>">Mobile Phone Policy</a>
                            <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
                                      in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="<?= base_url('computing-support/mobile-policy/accepted');?>">Accepted</a>
                            <?php } ?>
                        </td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/room-move')?>">Room Move Request</a>
                            - <a href="<?= base_url('computing-support/room-move/check');?>">Check</a>
                            <?php if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                                      in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                - <a href="<?= base_url('computing-support/room-move/pending');?>">Pending</a>
                            <?php } if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                                      in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                    - <a href="<?= base_url('computing-support/room-move/history');?>">History</a>
                            <?php } ?>
                        </td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/ownership/check')?>">Ownership Transfer Progress</a></td>
                        <td></td><td></td><td></td>
                    </tr>
                </tbody>
            </table> <br>
            
            <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                
            <p><b>Computing Support</b></p>
                
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
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="<?= base_url('computing-support/equipment-loan');?>">Equipment Loan</a>
                                - <a href="<?= base_url('computing-support/equipment-loan/history');?>">History</a></td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="computing-support/ownership">Ownership Transfer</a>
                                - <a href="computing-support/ownership/check">Check Progress</a>
                                - <a href="computing-support/ownership/review">Pending</a>
                                - <a href="computing-support/ownership/history">History</a></td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="computing-support/disposals">Disposals</a>
                                - <a href="computing-support/disposals/current">Current Export</a>
                                <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                    - <a href="computing-support/disposals/complete">Complete Current - (Finance Approved/Container Emptyed)</a>
                                <?php } ?>
                                - <a href="computing-support/disposals/history">History</a></td>
                            <td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table> <br>
            
            <?php } ?>
                
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->