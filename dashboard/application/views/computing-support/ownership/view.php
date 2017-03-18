<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

    $this->db->select('first_name');
    $this->db->select('last_name');
    $this->db->select('username');
    $this->db->order_by("first_name", "asc");
    $query = $this->db->get('users_ad');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $row_set[] = htmlentities(stripslashes($row['first_name'] . ' ' . $row['last_name']. ' (' . $row['username']. ')')); //build an array
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
                $(this).val(ui.item ? ui.item : " ");},

            change: function (event, ui) {
                if (!ui.item) {
                    this.value = '';}
                else{
                 // return your label here
                }
            }
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
        <?php $this->load->view('templates/toolbars/computing-support/ownership.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Ownership Transfer</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="logged">Logged by</label>
                <input type="text" class="form-control" id="logged" name="logged" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="staff_full">Staff full name *</label>
                <input type="text" class="form-control name" id="staff_full" name="staff_full" placeholder="Enter staff full name" value="<?= set_value('staff_full') ?>">
            </div>
            <div class="form-group">
                <label for="make">Make *</label>
                <input type="text" class="form-control" id="make" name="make" placeholder="Enter device make" value="<?= set_value('make') ?>">
            </div>
            <div class="form-group">
                <label for="model">Model *</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Enter device model" value="<?= set_value('model') ?>">
            </div>
            <div class="form-group">
                <label for="sn">Serial Number *</label>
                <input type="text" class="form-control" id="sn" name="sn" placeholder="Enter device serial number" value="<?= set_value('sn') ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Submit">
            </div>
            </form>
            <a href="https://intranet.cant-col.ac.uk/application/files/6814/6842/1272/IT_Equipment_Ownership_Transfer_Terms.pdf"> Ownership Transfer Policy.pdf</a>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

