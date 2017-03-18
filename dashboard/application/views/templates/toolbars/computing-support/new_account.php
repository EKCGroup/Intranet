<?php $this->load->view('templates/toolbars/computing-support/default.php'); ?>
        <li><a href="<?= base_url('computing-support/new-account')?>"><i class="fa fa-plus" aria-hidden="true"></i>  New Account</a></li>
        <li><a href="<?= base_url('computing-support/new-account/pending')?>"><i class="fa fa-exclamation" aria-hidden="true"></i> Pending</a></li>
        <li><a href="<?= base_url('computing-support/new-account/history')?>"><i class="fa fa-history" aria-hidden="true"></i> History</a></li>
        <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/new-account/export')?>"><i class="fa fa-tasks" aria-hidden="true"></i>  Export New Staff</a></li>
        <?php } ?>
        <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/new-account/complete')?>"><i class="fa fa-check" aria-hidden="true"></i>  Manually Complete All New Staff</a></li>
        <?php } ?>
    </ul>
</div>