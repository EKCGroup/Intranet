<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('templates/toolbars/computing-support/room_move.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Room Move History</h1>

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
                        <th>Reason</th>
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
                        <td width="20%"><?= $room['reason'] ?></td>
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
                            <?php if (in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                                <?php switch ($room['status']) {
                                    case 0: ?>
                                        <input type="button" value="Approve" name="approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/eh-approve?id='.$room['id']); ?>';"/>
                                        <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/history?reid='.$room['id']); ?>';"/>
                                <?php break;
                                      default: ?>
                                          No action Required
                                <?php break; ?>
                            <?php } } elseif (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?> 
                                    <?php switch ($room['status']) {
                                        case 0: ?>
                                            <input type="button" value="Overide Estates" name="overide_approve" class="btn btn-default" data-toggle="modal" data-target="#overide"/>
                                            <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/history?rcid='.$room['id']); ?>';"/>
                                    <?php break; 
                                          case 1: ?>
                                              <input type="button" value="Approve" name="approve" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/cs-approve?id='.$room['id']); ?>';"/>
                                              <input type="button" value="Reject" name="reject" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/history?rcid='.$room['id']); ?>';"/>
                                    <?php break;
                                          case 5: ?>
                                              <input type="button" value="Move Complete" name="complete" class="btn btn-default" onclick="location.href = '<?= base_url('computing-support/room-move/cs-complete?id='.$room['id']); ?>';"/>
                                    <?php break;
                                          default: ?>
                                              No action Required
                                    <?php break; }?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if (isset($_GET['reid'])) { ?>
            
                <script> 
                    $(document).ready(function () {
                        $('#re').modal('show');
                    });
                </script>

                <div class="modal fade" id="re" tabindex="-1" role="dialog" aria-labelledby="re">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><b>Reject Move</b></h4>
                            </div>
                            <div class="modal-body">
                                <h4><b>Are you sure you want to reject this request?</b></h4><br>
                                <!--<label>Please give a reason?</label>-->
                                <!--<textarea class="form-control" rows="3" id="re-reason" name="re-reason" placeholder="Enter reason"></textarea>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <input type="submit" class="btn btn-danger" value="Reject" onclick="location.href = '<?= base_url('computing-support/room-move/eh-reject?id='.$_GET['reid']); ?>';">
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php } if (isset($_GET['rcid'])) { ?>
            
                <script> 
                    $(document).ready(function () {
                        $('#rc').modal('show');
                    });
                </script>

                <div class="modal fade" id="rc" tabindex="-1" role="dialog" aria-labelledby="rc">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><b>Reject Move</b></h4>
                            </div>
                            <div class="modal-body">
                                <h4><b>Are you sure you want to reject this request?</b></h4><br>
                                <!--<label>Please give a reason?</label>-->
                                <!--<textarea class="form-control" rows="3" id="rc-reason" name="rc-reason" placeholder="Enter reason"></textarea>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" onclick="location.href = '<?= base_url('computing-support/room-move/cs-reject?id='.$_GET['rcid']); ?>';">Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php } ?>

                <div class="modal fade" id="overide" tabindex="-1" role="dialog" aria-labelledby="re">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><b>Overide Estates</b></h4>
                            </div>
                            <div class="modal-body">
                                <h4><b>Are you sure you want to overide Estates?</b></h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" onclick="location.href = '<?= base_url('computing-support/room-move/cs-approve?id='.$room['id']); ?>';">Overide</button>
                            </div>
                        </div>
                    </div>
                </div>

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

