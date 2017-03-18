<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script>
    function reload() {
        var x = document.getElementById("faculty").selectedIndex;
        window.location.href = "/dashboard/computing-support/address-book?cat=" + document.getElementsByTagName("option")[x].value;
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
        <?php $this->load->view('templates/toolbars/computing-support/address_book.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Address Book Update</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="full">Current full name</label>
                <input type="text" class="form-control" id="full" name="full" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group"> 
                <label for="faculty">Change faculty to...</label>
                <?= form_dropdown('faculty', $faculty, $_GET['cat'], 'onchange="reload()" id="faculty" class="form-control"') ?>
            </div>
            <div class="form-group">
		<label for="department">Change department to...</label>
                <?= form_dropdown('department', $department, '', 'class="form-control"') ?>
            </div>
            <div class="form-group">
                <label for="name">Change name from (<?= $_SESSION['ldap']['full_name'] ?>) to...</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="room">Change room to...</label>
                <input type="text" class="form-control" id="room" name="room" placeholder="Enter room">
            </div>
            <div class="form-group">
                <label for="phone">Change phone from (<?= $_SESSION['ldap']['phone'] ?>) to...</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="position">Change position from (<?= $_SESSION['ldap']['position'] ?>) to...</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Enter position">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Submit">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

