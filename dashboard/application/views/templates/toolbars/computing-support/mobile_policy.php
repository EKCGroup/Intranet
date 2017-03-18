<?php $this->load->view('templates/toolbars/computing-support/default.php'); ?>
        <li><a href="<?= base_url('computing-support/mobile-policy')?>"><i class="fa fa-mobile" aria-hidden="true"></i> Agree Mobile Policy</a></li>
        <?php if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
            <li><a href="<?= base_url('computing-support/mobile-policy/accepted')?>"><i class="fa fa-history" aria-hidden="true"></i> History</a></li>
        <?php } ?>
    </ul>
</div>