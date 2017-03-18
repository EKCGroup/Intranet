<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
        <?php $this->load->view('templates/toolbars/computing-support/mobile_policy.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Mobile Phone Policy</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="full_name">Full name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION['ldap']['email'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number *</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" value="<?= set_value('mobile') ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Accept">
            </div>
            </form>
            <a href="https://intranet.cant-col.ac.uk/application/files/7514/6842/1492/Mobile_Phone_Policy.pdf"> Mobile Phone Policy.pdf</a>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

