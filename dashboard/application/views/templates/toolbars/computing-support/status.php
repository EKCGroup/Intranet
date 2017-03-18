<?php $this->load->view('templates/toolbars/computing-support/default.php'); ?>
        <?php if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/status/create')?>"><i class="fa fa-plus" aria-hidden="true"></i> New monitor</a></li>
        <?php } ?>
    </ul>
</div>