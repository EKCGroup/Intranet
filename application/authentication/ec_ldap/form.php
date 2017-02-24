<?php 
defined('C5_EXECUTE') or die('Access denied.');

?>
<form method='post' action='<?php echo  URL::to('/login', 'authenticate', $this->getAuthenticationTypeHandle()) ?>'>

    <?php 
    $user = new User;

    if ($user->isLoggedIn()) {
        ?>
        <div class="form-group">
            <input name="uName" class="form-control col-sm-12"
                   placeholder="<?php echo  Config::get('concrete.user.registration.email_registration') ? t('Email Address') :
                       t('Username') ?>"/>
        </div>

        <div class="form-group">
            <input name="uPassword" class="form-control" type="password"
                   placeholder="Password"/>
        </div>
		<br />
        <div class="form-group">
            <button class="btn btn-primary"><?php echo  t('Attach account') ?></button>
        </div>
        <?php 
    } else {
        ?>

        <?php 
        if (count($directories) > 1) {
            ?>
            <div class="form-group">
                <label for="lDirectory" style="font-weight: normal">Directory</label>
                <select id="lDirectory" name="lDirectory" class="form-control col-sm-12">
                    <?php 
                    foreach ($directories as $directory) {
                        echo '<option value="' . $directory['id'] . '">' . $directory['displayName'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php 
        }
        ?>

        <div class="form-group">
            <?php 
            if (count($directories) > 1) {
                echo '<label>&nbsp;</label>';
            }
            ?>
            <input name="uName" class="form-control col-sm-12"
                   placeholder="<?php echo  Config::get('concrete.user.registration.email_registration') ? t('Email Address') :
                       t('Username') ?>"/>
        </div>

        <div class="form-group">
            <input name="uPassword" class="form-control" type="password"
                   placeholder="Password"/>
        </div>
		<br />
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="<?php echo  t('Log in') ?>"/>
        </div>

        <?php  Core::make('token')->output('login_' . $this->getAuthenticationTypeHandle()); ?>
        <?php 
    }
    ?>
</form>

<style type="text/css">
    ul.auth-types > li .ccm-auth-type-icon {
        position: absolute;
        top: 2px;
        left: 0;
    }
</style>