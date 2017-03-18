<?php defined('BASEPATH') OR exit('No direct script access allowed');

$this->db->select('first_name');
$this->db->select('last_name');
$this->db->select('username');
$this->db->order_by("first_name", "asc");
$query = $this->db->get('users_ad');
if ($query->num_rows() > 0) {
    foreach ($query->result_array() as $row) {
        $row_set[] = htmlentities(stripslashes($row['first_name'] . ' ' . $row['last_name'] . ' (' . $row['username'] . ')')); //build an array
    }
}
?>

<script>
    $(function () {
        $('.name').autocomplete({
            source: <?= json_encode($row_set) ?>,

            select: function (event, ui) {
                return false;
            },

            select: function (event, ui) {
                $(this).val(ui.item ? ui.item : " ");
            },

            change: function (event, ui) {
                if (!ui.item) {
                    this.value = '';
                } else {
                    // return your label here
                }
            }
        });
    });

    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: 'd/m/yy',
            beforeShowDay: $.datepicker.noWeekends,
            minDate: 7,
        });
    });
</script>

<div class="container-fluid">
    <div class="row">
<?php if (validation_errors()) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
    <?= validation_errors() ?>
                </div>
            </div>
        <?php endif; ?>
<?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
    <?= $error ?>
                </div>
            </div>
            <?php endif; ?>
        <?php $this->load->view('templates/toolbars/computing-support/room_move.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Room Move</h1>
<?= form_open() ?>
            <div class="form-group">
                <label for="logged">Logged by </label>
                <input type="text" class="form-control" id="logged" name="logged" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="move">Move date * (Must be 1 week in advance)</label>
                <input type="text" class="form-control datepicker" id="move" name="move" placeholder="Enter move date"  value="<?= set_value('move') ?>" readonly>
            </div>
            <div class="form-group">
                <label for="from">Room from * (Current) (E.G. P105)</label>
                <input type="text" class="form-control" id="from" name="from" placeholder="Enter room from"  value="<?= set_value('from') ?>">
            </div>
            <div class="form-group">
                <label for="to">Room to * (New) (E.G. P109)</label>
                <input type="text" class="form-control" id="to" name="to" placeholder="Enter room to"  value="<?= set_value('to') ?>">
            </div>
            <div class="form-group"><label for="furniture">Furniture *</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="furniture_no" name="furniture_no" >
                    </span>
                    <input type="text"class="form-control" id="furniture" name="furniture" placeholder="Enter furniture which needs moving (If no furniture use checkbox) (Does not include PC)" value="<?= set_value('sn') ?>">
                </div>
                <label for="furniture" style="margin-left: 13px;"> <i class="fa fa-arrow-up" aria-hidden="true"></i> No furniture move (Only PC)</label>
            </div>
            <div class="form-group">
                <label for="reason">Reason for move *</label>
                <textarea class="form-control" rows="3" id="reason" name="reason" placeholder="Enter reason for move"><?= set_value('reason') ?></textarea>
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved * (Please list all staff)</label><br>
                <input type="text" class="form-control name" id="full_name" name="full_name" placeholder="Enter full name" value="<?= set_value('full_name') ?>" style="margin-left: 15px; width: 500px !important; display: inline-block;">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="2">
                <input type="text" class="form-control name" id="full_name2" name="full_name2" placeholder="Enter full name" value="<?= set_value('full_name2') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="3">
                <input type="text" class="form-control name" id="full_name3" name="full_name3" placeholder="Enter full name" value="<?= set_value('full_name3') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="4">
                <input type="text" class="form-control name" id="full_name4" name="full_name4" placeholder="Enter full name" value="<?= set_value('full_name4') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="5">
                <input type="text" class="form-control name" id="full_name5" name="full_name5" placeholder="Enter full name" value="<?= set_value('full_name5') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="6">
                <input type="text" class="form-control name" id="full_name6" name="full_name6" placeholder="Enter full name" value="<?= set_value('full_name6') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="7">
                <input type="text" class="form-control name" id="full_name7" name="full_name7" placeholder="Enter full name" value="<?= set_value('full_name7') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="8">
                <input type="text" class="form-control name" id="full_name8" name="full_name8" placeholder="Enter full name" value="<?= set_value('full_name8') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="9">
                <input type="text" class="form-control name" id="full_name9" name="full_name9" placeholder="Enter full name" value="<?= set_value('full_name9') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="username" style="margin-right: 440px">Staff involved</label><br>
                <input type="checkbox" id="10">
                <input type="text" class="form-control name" id="full_name10" name="full_name10" placeholder="Enter full name" value="<?= set_value('full_name10') ?>" style="width: 500px !important; display: inline-block;" disabled="disabled">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Submit">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->


<script>
    $("#2").click(function () {
        $("#full_name2").attr("disabled", !this.checked).val('');
        $("#last2").attr("disabled", !this.checked).val('');
    });
    $("#3").click(function () {
        $("#full_name3").attr("disabled", !this.checked).val('');
        $("#last3").attr("disabled", !this.checked).val('');
    })
            ;
    $("#4").click(function () {
        $("#full_name4").attr("disabled", !this.checked).val('');
        $("#last4").attr("disabled", !this.checked).val('');
    });
    ;
    $("#5").click(function () {
        $("#full_name5").attr("disabled", !this.checked).val('');
        $("#last5").attr("disabled", !this.checked).val('');
    });
    ;
    $("#6").click(function () {
        $("#full_name6").attr("disabled", !this.checked).val('');
        $("#last6").attr("disabled", !this.checked).val('');
    });
    ;
    $("#7").click(function () {
        $("#full_name7").attr("disabled", !this.checked).val('');
        $("#last7").attr("disabled", !this.checked).val('');
    });
    ;
    $("#8").click(function () {
        $("#full_name8").attr("disabled", !this.checked).val('');
        $("#last8").attr("disabled", !this.checked).val('');
    });
    ;
    $("#9").click(function () {
        $("#full_name9").attr("disabled", !this.checked).val('');
        $("#last9").attr("disabled", !this.checked).val('');
    });
    ;
    $("#10").click(function () {
        $("#full_name10").attr("disabled", !this.checked).val('');
        $("#last10").attr("disabled", !this.checked).val('');
    });
    
    $('#furniture_no').click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            $("#furniture").attr('readonly', this.checked).val('');
        } else {
            $("#furniture").attr('readonly', this.checked).val('No Furniture');
        }
        $(this).data("clicks", !clicks);
    });
</script>