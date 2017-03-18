<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

if (isset($_GET['id']) && isset($_COOKIE['CI_PASSKEY'])) {
    $passid = $_GET['id'];
    $details = $this->user_model->get_passkey_details($passid);
    
    if (in_array($passid, $current_array = unserialize($_COOKIE['CI_PASSKEY']))) {
        redirect($details[0]['url']);
    }
}
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
        <div class="col-lg-12">
            <h1 class="page-header">Passkey</h1>
            <div class="col-md-5">
                <p>Please enter the passkey.</p>
                <?php if (isset($_GET['id']) === TRUE) {
                    echo form_open(current_url().'?id='.$_GET['id']);
                } else {
                    echo form_open();
                } ?>
                    <div class="form-group">
                        <label for="passid">PassID</label>
                        <?php if (isset($_GET['id']) === TRUE) { ?>
                        <input type="text" class="form-control" id="passid" name="passid" value="<?= $_GET['id'] ?>" readonly required>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="passid" name="passid" placeholder="Enter passid">
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="passkey">Passkey</label>
                        <input type="text" class="form-control" id="passkey" name="passkey" placeholder="Enter Passkey">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="Login">
                    </div>
                </form>
            </div>
        </div> <!-- END col-lg-12 -->
    </div> <!-- END row -->
</div> <!-- END container-fluid -->