<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/private-drive.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Private Drive Access History</h1>

            <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>User</th>
                        <th>Path</th>
                        <th>Access</th>
                        <th>Approver</th>
                        <th>Actioned by</th>
                        <th>Actioned</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($private_drive as $drive): ?>
                    <tr>
                        <td><?= $drive['requester'] ?></td>
                        <td><?= $drive['user'] ?></td>
                        <td><?= $drive['path'] ?></td>
                        <td><?= $drive['access'] ?></td>
                        <td><?= $drive['approver'] ?></td>
                        <td><?= $drive['actioned_by'] ?></td>
                        <td><?= $drive['actioned_at'] ?></td>
                            <?php switch ($drive['status']) {
                                case 0: echo "<td class='info'>Pending Faculty Head</td>";
                                    break;
                                case 1: echo "<td class='info'>Pending CS</td>";
                                    break;
                                case 2: echo "<td class='success'>CS Actioned</td>";
                                    break;
                                case 3: echo "<td class='danger'>Faculty Head Rejected</td>";
                                    break;
                                case 4: echo "<td class='danger'>CS Rejected</td>";
                                    break;
                                case 5: echo "<td class='danger'>Cancel by ".$drive['canceled_by']."</td>";
                                    break;
                            }?>
                        <td>
                            <?php switch ($drive['status']) {
                                case 0: ?>
                                    <input type="button" value="Overide Actioned" name="overide_approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/private-drive/cs-approve?id='.$drive['id']); ?>';"/>
                                    <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/private-drive/cs-reject?id='.$drive['id']); ?>';"/>
                          <?php break; 
                                case 1: ?>
                                    <input type="button" value="Actioned" name="approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/private-drive/cs-approve?id='.$drive['id']); ?>';"/>
                                    <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/private-drive/cs-reject?id='.$drive['id']); ?>';"/>
                          <?php break;
                                default: ?>
                                    No action Required
                          <?php break; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

<script>
    $(document).ready(function(){
        $('#datatable').DataTable( {
            iDisplayLength: 50,
        } );
    });
</script>

