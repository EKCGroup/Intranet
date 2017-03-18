<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/temporary_account.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Temporary Accounts Pending</h1>

            <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Logged</th>
                        <th>Requester</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($temporary_account as $temp): ?>
                    <tr>
                        <td><?= $temp['logged'] ?></td>
                        <td><?= $temp['requester'] ?></td>
                        <td><?= $temp['first_name'] ?></td>
                        <td><?= $temp['last_name'] ?></td>
                        <td><?= $temp['email'] ?></td>
                            <?php switch ($temp['status']) {
                                case 0: echo "<td class='info'>Pending</td>";
                                    break;
                                case 1: echo "<td class='sucess'>Approved</td>";
                                    break;
                                case 2: echo "<td class='danger'>Rejected</td>";
                                    break;
                                case 3: echo "<td class='danger'>Canceled</td>";
                                    break;
                            }?>
                        <td>
                            <?php if ($temp['status'] == 0) { ?>
                                <input type="button" value="Cancel" name="cancel" class="btn btn-default" onclick="location.href='<?= base_url('computing-support/temporary_account/cancel?id='.$temp['id']); ?>';"/>
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

