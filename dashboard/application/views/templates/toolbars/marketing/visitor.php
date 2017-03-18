<?php $this->load->view('templates/toolbars/marketing/default.php'); ?>
        <li><a href="<?= base_url('marketing/visitor')?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Visitor Form</a></li>
        <?php if (in_array('CN=Intranet_Edit_Marketing,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                  in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['dashboard_groups'])) { ?>
            <li><a href="<?= base_url('marketing/visitor/history')?>"><i class="fa fa-history" aria-hidden="true"></i> History</a></li>
            <li><a href="<?= base_url('marketing/visitor/reset')?>"><i class="fa fa-undo" aria-hidden="true"></i> Reset Data</a></li>
        <?php } ?>
    </ul>
</div>