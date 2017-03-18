<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/ownership.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Ownership Transfer Review</h1>

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
                            }?>
                        <td>
                            <?php if ($ownership_item['status'] == 0) { ?>
                                <input type="button" value="Overide Approve" name="overide_approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/ownership/approve?id='.$ownership_item['id']); ?>';"/>
                                <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/ownership/reject?id='.$ownership_item['id']); ?>';"/>
                            <?php } elseif ($ownership_item['status'] == 1) { ?>
                                <input type="button" value="Approve" name="approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/ownership/approve?id='.$ownership_item['id']); ?>';"/>
                                <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/ownership/reject?id='.$ownership_item['id']); ?>';"/>
                            <?php } ?>
                            </td>
                            </tr>
                            <?php endforeach;
                            ?>
                </tbody>
            </table>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

