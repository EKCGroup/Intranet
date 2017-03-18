<?php $this->load->view('templates/toolbars/computing-support/default.php'); ?>
        <li><a href="<?= base_url('computing-support/disposals')?>"><i class="fa fa-trash" aria-hidden="true"></i> New Disposals</a></li>
        <li><a href="<?= base_url('computing-support/disposals/export_current')?>"><i class="fa fa-history" aria-hidden="true"></i> Current Export</a></li>
        <li><a href="<?= base_url('computing-support/disposals/current')?>"><i class="fa fa-history" aria-hidden="true"></i> Current History</a></li>
        <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/disposals/complete')?>"><i class="fa fa-history" aria-hidden="true"></i> Complete Current</a></li>
        <?php } ?>
        <li><a href="<?= base_url('computing-support/disposals/history')?>"><i class="fa fa-history" aria-hidden="true"></i> History</a></li>
    </ul>
</div>