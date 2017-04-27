<?php defined('C5_EXECUTE') or defined('BASEPATH') or die("Access Denied."); ?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="dropdown" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php if (isset($is_codeigniter)) { ?>
        
            <a class="navbar-brand" href="/cc"><div class="intranetSprite" id="spriteCollegeLogo"  alt="Canterbury College Logo"></div></a>
            <a class="navbar-brand" href="/ekc"><div class="intranetSprite" id="spriteEKCLogo"  alt="East Kent College Logo"></div></a>
        
        <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
        
            <?php
                $v = View::getInstance();
                if ($v->getThemeHandle() == 'ccintranet') { ?>
                    <a class="navbar-brand" href="/cc"><div class="intranetSprite" id="spriteCollegeLogo"  alt="Canterbury College Logo"></div></a>
                    <a class="navbar-brand" href="/ekc"><div class="intranetSprite" id="spriteEKCLogo"  alt="East Kent College Logo"></div></a>
            <?php } elseif ($v->getThemeHandle() == 'ekcintranet') { ?>
                    <a class="navbar-brand" href="/ekc"><div class="intranetSprite" id="spriteEKCLogo"  alt="East Kent College Logo"></div></a>
                    <a class="navbar-brand" href="/cc"><div class="intranetSprite" id="spriteCollegeLogo"  alt="Canterbury College Logo"></div></a>
            <?php } ?>
        
        <?php /* END Concrete5*/ } ?>
    </div> <!-- END nav-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li>
            <?php if (isset($is_codeigniter)) { ?>

                <p class="welcome-username">
                    <?php if (isset($_COOKIE['CI-CONCRETE5']) === FALSE) { 
                        echo "<a href='/authentication/dashboard?url=".current_url()."'>Click here to Login</a>";
                    } else {
                        echo "Welcome ".$_SESSION['username'];
                    } ?>            
                </p>

            <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>

                <?php Loader::element('logged-in-user'); ?>

            <?php /* END Concrete5*/ } ?>
        </li> <!-- END dropdown -->
    </ul><!-- END navbar-top-links navbar-right -->
    
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php if (isset($is_codeigniter)) { ?>

                    <li>
                        <a href="/cc">Back to the Intranet <i class="fa fa-arrow-left fa-lg"></i></a>
                    </li>
                    <li>
                        <a href="<?= base_url('home') ?>">Dashboard</a>
                    </li>
                    <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { 
                        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) { ?>
                            <li>
                                <a href="#"> - Admin <span style="margin-top: -5px;" class="fa arrow fa-lg"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                       <a href="/dashboard/admin">All Settings</a>
                                    </li>
                                    <li>
                                       <a href="/dashboard/admin/user/intranet">Intranet Users</a>
                                    </li>
                                    <li>
                                       <a href="/dashboard/admin/user/dashboard">Dashboard Users</a>
                                    </li>
                                    <li>
                                       <a href="/dashboard/admin/user/passkey">Passkeys</a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>
                    <li>
                        <a href="<?= base_url('computing-support') ?>">Computing Support</a>
                    </li>
                    <li>
                        <a href="<?= base_url('human-resources')?>">Human Resources</a>
                    </li>
                    <li>
                        <a href="<?= base_url('marketing') ?>">Marketing</a>
                    </li>
                    <?php if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) { ?>
                        <li>
                            <a href="<?= base_url('logout') ?>">Logout <i class="fa fa-sign-out fa-lg"></i></a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="/authentication/dashboard?url=<?= current_url() ?>">Login <i class="fa fa-sign-in fa-lg"></i></a>
                        </li>
                    <?php } ?>

                <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>

                    <?php
                        $v = View::getInstance();
                        if ($v->getThemeHandle() == 'ccintranet') {
                            $a = new GlobalArea('CC Side Navigation'); $a->display($c);
                            $a = new GlobalArea('Global Side Navigation'); $a->display($c);
                        } elseif ($v->getThemeHandle() == 'ekcintranet') {
                            $a = new GlobalArea('EKC Side Navigation'); $a->display($c);
                            $a = new GlobalArea('Global Side Navigation'); $a->display($c);
                        }
                    ?>

                <?php /* END Concrete5*/ } ?>
            </ul> <!-- side-menu --> 
        </div> <!-- END sidebar-nav -->
    </div> <!-- END sidebar -->
</nav>

<?php if (isset($is_codeigniter)) { ?>

    <?php
        $url = $_SERVER['REQUEST_URI'];

        if (strpos($url,'computing-support') !== false) {
            $dept_name = 'Computing Support';
            $dept_url = 'computing-support';
        } elseif (strpos($url,'marketing') !== false) {
            $dept_name = 'Marketing';
            $dept_url = 'marketing';
        } elseif (strpos($url,'human-resources') !== false) {
            $dept_name = 'Human Resources';
            $dept_url = 'human-resources';
        } else {
            $dept_name = '';
            $dept_url = '';
        }
    ?>

<?php /* END Codeigniter */ } ?>

<div class="breadcrumb">
    <?php if (isset($is_codeigniter)) { ?>
        
        <a href="<?= base_url('home') ?>"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a> <a href="/">Home</a> / <a href="<?= base_url() ?>">Dashboard</a> / <a href="<?= base_url($dept_url) ?>"><?= $dept_name ?></a> / <?php echo set_breadcrumb(); ?>
    
    <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
    
        <?php $a = new GlobalArea('Breadcrumb'); $a->display($c); ?>
        
    <?php /* END Concrete5*/ } ?>
        
        
    <script type="text/javascript">
        $(".breadcrumb a").click(function(e) {
            e.preventDefault();
        });
    </script>
</div>
<div class="title">
    <?php if (isset($is_codeigniter)) { ?>
    
    <?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
    
        <?php $page = Page::getCurrentPage(); echo $page->getCollectionName(); ?>
        
    <?php /* END Concrete5*/ } ?>
</div>

<?php if (isset($is_codeigniter)) { ?>
    
<?php /* END Codeigniter */ } else { /* IF Concrete5 */ ?>
    
    <div class="global-notification">
        <?php
            $a = new GlobalArea('Global Notification'); $a->display($c);

            $v = View::getInstance();
            if ($v->getThemeHandle() == 'ccintranet') {
                $a = new GlobalArea('CC Global Notification'); $a->display($c);
            } elseif ($v->getThemeHandle() == 'ekcintranet') {
                $a = new GlobalArea('EKC Global Notification'); $a->display($c);
            }
        ?>
    </div> <!-- END global-notification -->
        
<?php /* END Concrete5*/ }
 
