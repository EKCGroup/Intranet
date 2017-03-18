<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/room_move.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Room Move Check</h1>

            <table id="datatable" class="table table-striped sortable table-hover">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Requested At</th>
                        <th>Move Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Furniture</th>
                        <th>Staff Involved</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($room_move as $room): ?>
                    <tr>
                        <td><?= $room['requester'] ?></td>
                        <td><?= $room['requested_at'] ?></td>
                        <td><?= $room['move'] ?></td>
                        <td><?= $room['from'] ?></td>
                        <td><?= $room['to'] ?></td>
                        <td><?= $room['furniture'] ?></td>
                        <td>
                            <?= $room['staff_involved'] ?>
                            <?php if (isset($room['staff_involved2'])) { echo '<br>'. $room['staff_involved2']; } ?>
                            <?php if (isset($room['staff_involved3'])) { echo '<br>'. $room['staff_involved3']; } ?>
                            <?php if (isset($room['staff_involved4'])) { echo '<br>'. $room['staff_involved4']; } ?>
                            <?php if (isset($room['staff_involved5'])) { echo '<br>'. $room['staff_involved5']; } ?>
                            <?php if (isset($room['staff_involved6'])) { echo '<br>'. $room['staff_involved6']; } ?>
                            <?php if (isset($room['staff_involved7'])) { echo '<br>'. $room['staff_involved7']; } ?>
                            <?php if (isset($room['staff_involved8'])) { echo '<br>'. $room['staff_involved8']; } ?>
                            <?php if (isset($room['staff_involved9'])) { echo '<br>'. $room['staff_involved9']; } ?>
                            <?php if (isset($room['staff_involved10'])) { echo '<br>'. $room['staff_involved10']; } ?>
                        </td>
                            <?php switch ($room['status']) {
                                case 0: ?>
                                    <td class='info'>Pending Estates</td>
                          <?php break; 
                                case 1: ?>
                                    <td class='info'>Pending CS</td>
                          <?php break;
                                case 2: ?>
                                    <td class='danger'>Estates Rejected</td>
                          <?php break;
                                case 3: ?>
                                    <td class='danger'>CS Rejected</td>
                          <?php break;
                                case 4: ?>
                                    <td class='danger'>Canceled</td>
                          <?php break;
                                case 5: ?>
                                    <td class='warning'>Pending Completion</td>
                          <?php break;
                                case 6: ?>
                                    <td class='success'>Move Complete</td>
                          <?php break;?>
                            <?php } ?>
                        <td>
                            <?php switch ($room['status']) {
                                case 0:
                                case 1:
                                case 5: ?>
                                    <?php if ($_SESSION['username'] == $room['requester_un']) { ?>
                                        <input type="button" value="Cancel" name="camcel" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/cancel?id='.$room['id']); ?>';"/>
                                    <?php } else { ?>
                                        No Action Required
                                    <?php } ?>
                          <?php break; 
                                default: ?>
                                    No Action Required
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

