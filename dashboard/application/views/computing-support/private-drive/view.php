<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

<link type="text/css" rel="stylesheet" href="/application/elements/theme/global/vendor/jstree-3.3.1/themes/default/style.min.css" />
<script type="text/javascript" src="/application/elements/theme/global/vendor/jstree-3.3.1/jstree.min.js" type="text/javascript"></script>

<script>
    $(function () {
        //autocomplete
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

        //jstree
        $('#jstree').jstree({'core': {
                'data': {
                    'url': '<?= base_url() ?>assets/filetree.json'
                }
            }});

        // jstree to input
        $('#jstree').on("changed.jstree", function (e, data) {
            var path = data.instance.get_path(data.node, '\\');
            $('#path').val(path);
        });
    });

    function reload() {
        var x = document.getElementById("faculty").selectedIndex;
        window.location.href = "/dashboard/computing-support/private-drive?cat=" + document.getElementsByTagName("option")[x].value;
    }
</script>



<?php
    $ldap = ldap_connect("172.16.5.46");
    if ($ldap && $bind = @ldap_bind($ldap, "CANT-COL\\ldapquery", "l108pabxy02")) {

    } else {
        echo "Error binding to AD";
    }

    $query = ldap_search($ldap, "OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk", "CN=Dashboard_Faculty_Head");
    $data = ldap_get_entries($ldap, $query);

    for ($i = 0; $i < $data['count']; $i++) {
        $members = $data[$i]['member'];
        unset($members['count']);
    }
    foreach ($members as $value) {
        $a = substr($value, 0, strpos($value, ","));
        $b = strstr($a, '=');
        $c = substr($b, 1);
        $members2[] = $c;
    };
?> 


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
        <?php $this->load->view('templates/toolbars/computing-support/private-drive.php'); ?>
        <div class="col-lg-12">
            <h1 class="page-header">Private Drive Access</h1>
            <?= form_open() ?>
            <div class="form-group">
                <label for="requester">Applied by</label>
                <input type="text" class="form-control" id="requester" name="requester" value="<?= $_SESSION['ldap']['full_name'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="user">Staff requiring access *</label>
                <input type="text" class="form-control name" id="user" name="user" placeholder="Enter staff requiring access" value="<?= set_value('user') ?>">
            </div>
            <div class="form-group">
                <label for="path">Path *</label>
                <div id="jstree"></div><br>
                <input type="text" class="form-control" id="path" name="path" placeholder="Use finder above" value="<?= set_value('path') ?>" readonly>
            </div>
            <div class="form-group">
                <label for="access">Access Level * </label>
                <?php
                $options = array('Read Only' => 'Read Only', 'Read & Modify' => 'Read & Modify');
                echo form_dropdown('access', $options, $this->input->post('access'), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <label for="approver">Faculty head approver * </label>
                <select class="form-control" id="approver" name="approver">
                    <option value="" disabled selected>Select approver</option>
                    <?php foreach ($members2 as $student): ?>
                        <option value="<?= $student ?>" <?= set_select('approver'); ?>><?= $student ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Apply">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->

