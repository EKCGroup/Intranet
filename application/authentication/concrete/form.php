<?php defined('C5_EXECUTE') or die('Access denied.');

$form = Core::make('helper/form');
?>

<form method="post" action="<?php echo URL::to('/login', 'authenticate', $this->getAuthenticationTypeHandle()) ?>">

    <div class="form-group">
        <input name="uName" class="form-control col-sm-12" placeholder="<?php echo Config::get('concrete.user.registration.email_registration') ? t('Email Address') : t('Username') ?>" autofocus="autofocus" />
    </div>

    <div class="form-group">
        <input name="uPassword" class="form-control" type="password" placeholder="<?php echo t('Password') ?>" />
    </div>
    <br />
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo t('Log in') ?>"/>
    </div>

<?php Core::make('helper/validation/token')->output('login_' . $this->getAuthenticationTypeHandle()); ?>

</form>
