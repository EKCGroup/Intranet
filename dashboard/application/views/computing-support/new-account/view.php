<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script>
    function reload() {
        var x = document.getElementById("faculty").selectedIndex;
        window.location.href = "/dashboard/computing-support/new-account?cat=" + document.getElementsByTagName("option")[x].value;
    }
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
            <?php $this->load->view('templates/toolbars/computing-support/new_account.php'); ?>
            <div class="col-lg-12">
                <h1 class="page-header">Create Staff Account</h1>
		<?= form_open() ?>
                    <div class="form-group">
                        <label for="logged">Logged by </label>
                        <input type="text" class="form-control" id="logged" name="logged" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
                    </div>
                    <div class="form-group faculty-select"> 
			<label for="ern">Faculty *</label>
                        <?= form_dropdown('faculty', $faculty, $_GET['cat'], 'onchange="reload()" id="faculty" class="form-control"') ?>
                    </div>
                    <div class="form-group">
			<label for="ern">Department *</label>
                        <?= form_dropdown('department', $department, '', 'class="form-control"') ?>
                    </div>
                    <div class="form-group">
			<label for="username">First name*</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?= set_value('first_name') ?>">
                    </div>
                    <div class="form-group">
			<label for="username">Last name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?= set_value('last_name') ?>">
                    </div>
                    <div class="form-group">
			<label for="ern">Employee Reference no. *</label>
                        <input type="text" class="form-control" id="ern" name="ern" placeholder="Enter ERN" value="<?= set_value('ern') ?>">
                    </div>
                    <div class="form-group">
			<label for="position">Position *</label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="Enter position" value="<?= set_value('position') ?>">
                    </div>
                    <div class="form-group">
			<label for="room">Room *</label>
                        <input type="text" class="form-control" id="room" name="room" placeholder="Enter room" value="<?= set_value('room') ?>">
                    </div>
                    <div class="form-group">
			<label for="ext">Phone Number *</label>
                        <input type="text" class="form-control" id="ext" name="ext" placeholder="Enter phone number" value="<?= set_value('ext') ?>">
                    </div>
                    <div class="form-group">
			<label for="con_start">Contract Start Date *</label>
                        <input type="text" class="form-control datepicker" id="con_start" name="con_start" placeholder="Enter start date"  value="<?= set_value('con_start') ?>" readonly>
                    </div>
                    <div class="form-group">
			<label for="con-end">Contract End Date</label>
                        <input type="text" class="form-control datepicker" id="con_end" name="con_end" placeholder="Enter end date" value="<?= set_value('con_end') ?>" readonly>
                    </div>
                    <div class="form-group">
			<label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="PassWord1$" readonly>
                    </div>
                    <div class="form-group">
			<label for="site">Site* </label>
                        <?php $options = array('Canterbury' => 'Canterbury', 'Sheppey' => 'Sheppey'); echo form_dropdown('site', $options, $this->input->post('site'), 'class="form-control"'); ?>
                    </div>
                    <div class="form-group">
			<input type="submit" class="btn btn-default" value="Create">
                    </div>
		</form>
            </div> <!-- END col-lg-12 -->
        </div> <!-- END row -->
    </div> <!-- END container-fluid -->
    
<script>
    $('select[name=faculty] option').each(function() {
        if ($(this).text().indexOf('Please') >= 0) $(this).attr('disabled', 'disabled');
    });
    
    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: 'd/m/yy',
            beforeShowDay: $.datepicker.noWeekends,
            minDate: 1,
        });
    });
</script>
