<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/ownership.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Ownership Transfer Progress</h1>

            <table id="datatable" class="display table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ownership as $ownership_item): ?>
                        <tr>
                            <td><?= $ownership_item['staff_full'] ?></td>
                            <td><?= $ownership_item['make'] ?></td>
                            <td><?= $ownership_item['model'] ?></td>
                            <td><?= $ownership_item['sn'] ?></td>
                            <?php switch ($ownership_item['status']) {
                                case 0: echo "<td class='info'>Terms Pending</td>";
                                    break;
                                case 1: echo "<td class='info'>CS Pending</td>";
                                    break;
                                case 2: echo "<td class='danger'>Rejected</td>";
                                    break;
                                case 3: echo "<td class='success'>Approved</td>";
                                    break;
                                case 4: echo "<td class='danger'>Canceled</td>";
                                    break;
                            }?>
                            <td>
                                <?php if ($ownership_item['status'] == 0) { ?>
                                    <input type="button" value="Accept" name="accept" class="btn btn-default" onclick="location.href='<?= base_url('computing-support/ownership/terms?id='.$ownership_item['id']); ?>';"/>
                                    <input type="button" value="Cancel" name="cancel" class="btn btn-default" onclick="location.href='<?= base_url('computing-support/ownership/cancel?id='.$ownership_item['id']); ?>';"/>
                                <?php } else { ?>
                                    No action required
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

