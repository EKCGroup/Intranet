<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
    <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>

        <?php if ($this->notification_model->new_staff_account() === TRUE) { ?>
            <div class="alert alert-info" role="alert">
                New Staff Accounts Pending
            </div>
        <?php } ?>

    <?php } ?>
<?php }?>
<!-- #### PUBLIC #### -->

<?php if ($this->notification_model->status() === FALSE) {
      $status = $this->notification_model->status_view(); ?>
    <?php echo "<div class='alert alert-info' role='alert'> Service Fault: &nbsp;&nbsp; ";
          foreach ($status as $status_item): ?>
        <?php
            switch ($status_item['status']) {
                case 0:
                    echo $status_item['name'].", &nbsp;";
                    break;
                case 2:
                    switch ($status_item['auto_status']) {
                        case 0:
                            echo $status_item['name'].", &nbsp;";
                            break;
                    }
            }
             ?>                          
    <?php endforeach; 
          echo "</div>"; }?>


