<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->db->select('first_name');
$this->db->select('last_name');
$this->db->order_by("first_name", "asc");
$query = $this->db->get('users_ad');
if ($query->num_rows() > 0) {
    foreach ($query->result_array() as $row) {
        $row_set[] = htmlentities(stripslashes($row['first_name'] . ' ' . $row['last_name'])); //build an array
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

    function reload() {
        var x = document.getElementById("faculty").selectedIndex;
        window.location.href = "/dashboard/computing-support/temporary-account?cat=" + document.getElementsByTagName("option")[x].value;
    }
    
    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: 'd/m/yy',
            minDate: 1,
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
        <?php $this->load->view('templates/toolbars/computing-support/temporary_account.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Temporary Account Request</h1>
<?= form_open() ?>
            <div class="form-group">
                <label for="logged">Logged by</label>
                <input type="text" class="form-control" id="logged" name="logged" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group"> 
                <label for="ern">Faculty *</label>
<?= form_dropdown('faculty', $faculty, $_GET['cat'], 'onchange="reload()" id="faculty" class="form-control"') ?>
            </div>
            <div class="form-group">
                <label for="ern">Department *</label>
<?= form_dropdown('department', $department, '', 'class="form-control"') ?>
            </div>
            <div class="form-group">
                <label for="requester" style="margin-right: 440px">Staff requester *</label>
                <input type="text" class="form-control name" id="requester" name="requester" placeholder="Enter staff requester" value="<?= set_value('requester') ?>">
            </div>
            <div class="form-group">
                <label for="first_name">Users first name *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?= set_value('first_name') ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Users last name *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?= set_value('last_name') ?>">
            </div>
            <div class="form-group">
                <label for="email">Users email</label><span> Used to email pass direct to user.</span>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= set_value('email') ?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $tempid ?>" readonly>
            </div>
            <div class="form-group">
                <label for="expiry">Account expiry (end of day)*</label>
                <input type="text" class="form-control datepicker" id="expiry" name="expiry" placeholder="Enter account expiry"  value="<?= set_value('expiry') ?>" readonly>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Apply">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->