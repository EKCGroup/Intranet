<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<meta http-equiv='REFRESH' content='30;url=<?= base_url('computing-support/status/display') ?>'>

<style>
    .alert {
        display: none ;
    }
    .sidebar {
        display: none;
        width: 0px;
    }
    .title, .breadcrumb, #page-wrapper {
        margin-left: 0px;
    }
    nav.navbar.navbar-default.navbar-static-top, .breadcrumb, .title {
        display: none;
    }
    .container-fluid {
        margin-top: -120px !important;
    }
</style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">   
                <h1 class="page-header">Service Status</h1>
                
                <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th style="text-align: center;">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $status_item): if ($status_item['category'] == 'network') {} else {
                        $sid = $status_item['id'];?>
                        <tr>
                            <td> &nbsp; <i class="fa <?= $status_item['icon'];?>" aria-hidden="true"></i> &nbsp; <?= $status_item['name'];?></td>
                            <td class="col-md-1" style="text-transform: capitalize;"> <?= $status_item['category'] ?></td>

                            <?php
                                switch ($status_item['status']) {
                                    case 0:
                                        echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center;'>Fault</td>";
                                        break;
                                    case 1:
                                        echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK</td>";
                                        break;
                                    case 2:
                                        switch ($status_item['auto_status']) {
                                            case 0:
                                                echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center;'>Fault (Auto)</td>";
                                                break;
                                            case 1:
                                                echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK (Auto)</td>";
                                                break;
                                            default:
                                                echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                                break;
                                        }
                                        break;
                                    default:
                                        echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                        break;
                                }
                            ?>
                            <td class="col-md-1" style="text-align: center;"> <?= $this->status_model->percentage($sid) ?></td>
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
                                        echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center;'>Fault</td>";
                                        break;
                                    case 1:
                                        echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK</td>";
                                        break;
                                    case 2:
                                        switch ($status_item['auto_status']) {
                                            case 0:
                                                echo "<td class='col-md-2 danger' style='font-weight:bold; text-align: center;'>Fault (Auto)</td>";
                                                break;
                                            case 1:
                                                echo "<td class='col-md-2 success' style='font-weight:bold; text-align: center;'>OK (Auto)</td>";
                                                break;
                                            default:
                                                echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                                break;
                                        }
                                        break;
                                    default:
                                        echo "<td class='col-md-2 info' style='font-weight:bold; text-align: center;'>No data</td>";
                                        break;
                                }
                            ?>
                            <td class="col-md-1" style="text-align: center;"> <?= $this->status_model->percentage($sid) ?></td>
                        </tr>
                    <?php } endforeach; ?>
                </tbody>
            </table>
        </div> <!-- END row -->
    </div> <!-- END container-fluid -->