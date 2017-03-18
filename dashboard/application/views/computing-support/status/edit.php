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
        <?php $this->load->view('templates/toolbars/computing-support/status.php'); ?>
        <div class="col-lg-12">
            <?php if (strpos($_SERVER['REQUEST_URI'], 'create') == TRUE) { ?>
                <h1 class="page-header">Add</h1>
            <?php } elseif (strpos($_SERVER['REQUEST_URI'], 'edit') == TRUE) { ?>
                <h1 class="page-header">Edit</h1>
            
                <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                    <button onclick="window.location = '/dashboard/computing-support/status/delete?sid=<?= $_GET['sid'] ?>'" class="btn btn-default"> Delete </button>
                <?php } ?>
            <?php } ?>    
            <?= form_open() ?>
            <input type="text" id="id" name="id" value="<?php if (isset($_GET['sid'])) { echo $_GET['sid']; } ?>" readonly style="display: none;">
            <div class="form-group">
            <div class="form-group">
                <label for="name">Service name *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter service name" value="<?php if (isset($get_current[0]['name'])) { echo $get_current[0]['name']; } ?>" <?php if (!in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { echo 'readonly'; } ?>>
            </div>
            <div class="form-group">
                <label for="icon">Icon *</label>
                <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter icon" value="<?php if (isset($get_current[0]['icon'])) { echo $get_current[0]['icon']; } ?>" <?php if (!in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { echo 'readonly'; } ?>>
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="Enter url" value="<?php if (isset($get_current[0]['url'])) { echo $get_current[0]['url']; } ?>" <?php if (!in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { echo 'readonly'; } ?>>
            </div>
            <div class="form-group">
                <label for="category">Category *</label>
                <?php if (isset($get_current[0]['category'])) { $category_value = $get_current[0]['category']; } else { $category_value = NULL; } ?>
                <?php $options = array('web' => 'Web', 'communication' => 'Communication', 'file' => 'File', 'remote' => 'Remote','network' => 'Network', 'wireless' => 'Wireless');
                echo form_dropdown('category', $options, $category_value, 'class="form-control"'); ?>
            </div>
            <div class="form-group">
                <label for="comment">Comment &nbsp; (only displayed on, Fault, Fault (Auto), Intermediate)</label>
                <input type="text" class="form-control" id="comment" name="comment" value="<?php if (isset($get_current[0]['comments'])) { echo $get_current[0]['comments']; } ?>">
            </div>
            <div class="form-group">
                <label for="status">Force Status *</label>
                <?php if (isset($get_current[0]['status'])) { $status_value = $get_current[0]['status']; } else { $status_value = NULL; } ?>
                <?php $options = array('1' => 'Up', '2' => 'Auto', '0' => 'Down', '3' => 'Intermediate');
                echo form_dropdown('status', $options, $status_value, 'class="form-control"'); ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Update">
            </div>
            </form>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->