<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<meta http-equiv='REFRESH' content='60;url=<?= base_url('computing-support/status') ?>'>

    <div class="container-fluid">
        <div class="row">
            <?php if (isset($_COOKIE['CI-CONCRETE5'])) {
                $this->load->view('templates/toolbars/computing-support/status.php'); 
            } ?>
            <div class="col-lg-12">
                <h1 class="page-header">Service Status</h1>                
                <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th style="text-align: center;">Percentage</th>
                        <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
                        <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                            <th style="text-align: center;">Admin</th>
                        <?php }} ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $status_item): if ($status_item['category'] == 'network') {}else {
                        $sid = $status_item['id'];?>
                        <tr>
                            <td> &nbsp; <i class="fa <?= $status_item['icon'];?>" aria-hidden="true"></i> &nbsp; <?= $status_item['name'];?></td>
                            <td class="col-md-1" style="text-transform: capitalize;"> <?= $status_item['category'] ?></td>

                            <?php
                                switch ($status_item['status']) {
                                    case 0:
                                        echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center; position: relative'>Fault <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                        break;
                                    case 1:
                                        echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK</td>";
                                        break;
                                    case 2:
                                        switch ($status_item['auto_status']) {
                                            case 0:
                                                echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center; position: relative'>Fault (Auto) <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                                break;
                                            case 1:
                                                echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK (Auto)</td>";
                                                break;
                                            default:
                                                echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                                break;
                                        }
                                        break;
                                    case 3:
                                        echo "<td class='col-md-2 warning' style='font-weight:bold; text-align: center; position: relative'>Intermediate <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                        break;
                                    default:
                                        echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                        break;
                                }
                            ?>
                            <td class="col-md-1" style="text-align: center;"> <?= $this->status_model->percentage($sid) ?></td>
                            <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
                            <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                <td class="col-md-1" style="text-align: center;"> 
                                    <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                        <a href="<?= base_url('computing-support/status/reset?sid='.$sid); ?>"><i class="fa fa-undo" aria-hidden="true"></i></a> &nbsp;
                                    <?php } ?>
                                    <a href="<?= base_url('computing-support/status/edit?sid='.$sid); ?>"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </td>
                            <?php }} ?>
                        </tr>
                    <?php } endforeach; ?>
                </tbody>
            </table>
                
            <table class="table table-striped sortable">
                <thead>
                    <tr>
                        <th>Network</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Percentage</th>
                        <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
                        <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                            <th style="text-align: center;">Admin</th>
                        <?php }} ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $status_item): if ($status_item['category'] == 'network') {?>
                        <?php $sid = $status_item['id']; ?>
                        <tr>
                            <td> &nbsp; <i class="fa <?= $status_item['icon'];?>" aria-hidden="true"></i> &nbsp; <?= $status_item['name'];?></td>
                            <td class="col-md-1" style="text-transform: capitalize;"> <?= $status_item['category'] ?></td>

                            <?php
                                switch ($status_item['status']) {
                                    case 0:
                                        echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center; position: relative'>Fault <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                        break;
                                    case 1:
                                        echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK</td>";
                                        break;
                                    case 2:
                                        switch ($status_item['auto_status']) {
                                            case 0:
                                                echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center; position: relative'>Fault (Auto) <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                                break;
                                            case 1:
                                                echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK (Auto)</td>";
                                                break;
                                            default:
                                                echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                                break;
                                        }
                                        break;
                                    case 3:
                                        echo "<td class='col-md-2 warning' style='font-weight:bold; text-align: center; position: relative'>Intermediate <i class='fa fa-info-circle fa-lg' style='position: absolute; left: 10px; top: 12px;' data-toggle='tooltip' data-placement='bottom' title='". $status_item['comments'] ."'></i></td>";
                                        break;
                                    default:
                                        echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                        break;
                                }
                            ?>
                            <td class="col-md-1" style="text-align: center;"> <?= $this->status_model->percentage($sid) ?></td>
                            <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
                            <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                <td class="col-md-1" style="text-align: center;"> 
                                    <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                        <a href="<?= base_url('computing-support/status/reset?sid='.$sid); ?>"><i class="fa fa-undo" aria-hidden="true"></i></a> &nbsp;
                                    <?php } ?>
                                    <a href="<?= base_url('computing-support/status/edit?sid='.$sid); ?>"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </td>
                            <?php }} ?>
                        </tr>
                    <?php } endforeach; ?>
                </tbody>
            </table>
        </div> <!-- END row -->
    </div> <!-- END container-fluid -->