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
        <?php $this->load->view('templates/toolbars/computing-support/disposals.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Disposals</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="logged">Logged by </label>
                <input type="text" class="form-control" id="logged" name="logged" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="make">Make *</label>
                <input type="text" class="form-control" id="make" name="make" placeholder="Enter device make" value="<?= set_value('make') ?>">
            </div>
            <div class="form-group">
                <label for="model">Model *</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Enter device model" value="<?= set_value('model') ?>">
            </div>
            <div class="form-group"><label for="sn">Serial Number *</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" id="monitor" name="monitor" >
                    </span>
                    <input type="text"class="form-control" id="sn" name="sn" placeholder="Enter device serial number (If monitor use checkbox)" value="<?= set_value('sn') ?>">
                </div>
                <label for="monitor" style="margin-left: 13px;"> <i class="fa fa-arrow-up" aria-hidden="true"></i> Is monitor</label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Submit">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

<script>
    $('#monitor').click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            $("#sn").attr('readonly', this.checked).val('');
        } else {
            $("#sn").attr('readonly', this.checked).val('Monitor');
        }
        $(this).data("clicks", !clicks);
    });
</script>

