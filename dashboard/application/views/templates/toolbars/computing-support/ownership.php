<?php $this->load->view('templates/toolbars/computing-support/default.php'); ?>
        <?php if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/ownership')?>"><i class="fa fa-plus" aria-hidden="true"></i>  New Transfer</a></li>
        <?php } ?>
        <li><a href="<?= base_url('computing-support/ownership/check')?>"><i class="fa fa-tasks" aria-hidden="true"></i>  Check Status</a></li>
        <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/ownership/review')?>"><i class="fa fa-exclamation" aria-hidden="true"></i> Pending</a></li>
            <li><a href="<?= base_url('computing-support/ownership/history')?>"><i class="fa fa-history" aria-hidden="true"></i> History</a></li>
        <?php } ?>
    </ul>
</div>