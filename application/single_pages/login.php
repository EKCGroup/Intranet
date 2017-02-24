<?php defined('C5_EXECUTE') or die('Access denied.');

$activeAuths = AuthenticationType::getList(true, true);
?>
<h2>Please enter your ID and Password To Login.</h2>
<p>Staff Only:<p>
<div class="login-page">
    <style>.form-group span { visibility: hidden;}.form-group hr { visibility: hidden;} </style>

    <div class="authentication-form controls">
        <?php
        if ($attribute_mode) {
            $attribute_helper = new Concrete\Core\Form\Service\Widget\Attribute();
            ?>
            <form action="<?php echo View::action('fill_attributes') ?>" method="POST">
                <?php
                foreach ($required_attributes as $key) {
                    echo $attribute_helper->display($key, true);
                }
                ?>
                <button><?php echo t('Submit') ?></button>
            </form>
            <?php
        } else {
            foreach ($activeAuths as $auth) {
                ?>
                <div data-handle="<?php echo $auth->getAuthenticationTypeHandle() ?>" class="authentication-type authentication-type-<?php echo $auth->getAuthenticationTypeHandle() ?>">
                    <?php $auth->renderForm($authTypeElement ?: 'form', $authTypeParams ?: array()) ?>
                </div>
                <?php
            }
        }
        ?>
    </div> <!-- END authentication-form --><br>
    <div class="authentication-types">
        <ul class="auth-types">
            <?php
            if ($attribute_mode) {
                ?>
                <li data-handle="required_attributes">
                    <span><?php echo t('Attributes') ?></span>
                </li>
                <?php
            } else {
                foreach ($activeAuths as $auth) {
                    ?>
                    <li data-handle="<?php echo $auth->getAuthenticationTypeHandle() ?>">
                        <?php echo $auth->getAuthenticationTypeIconHTML() ?>
                        <span><?php echo $auth->getAuthenticationTypeName() ?></span>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div> <!-- END authentication-types -->
</div> <!-- END login-page -->

<script type="text/javascript">
    (function ($) {
        "use strict";

        var forms = $('div.controls').find('div.authentication-type').hide(),
                select = $('div.ccm-authentication-type-select > select');
        var types = $('ul.auth-types > li').each(function () {
            var me = $(this),
                    form = forms.filter('[data-handle="' + me.data('handle') + '"]');
            me.click(function () {
                select.val(me.data('handle'));
                if (typeof Concrete !== 'undefined') {
                    Concrete.event.fire('AuthenticationTypeSelected', me.data('handle'));
                }

                if (form.hasClass('active'))
                    return;
                types.removeClass('active');
                me.addClass('active');
                if (forms.filter('.active').length) {
                    forms.stop().filter('.active').removeClass('active').fadeOut(250, function () {
                        form.addClass('active').fadeIn(250);
                    });
                } else {
                    form.addClass('active').show();
                }
            });
        });

        select.change(function () {
            types.filter('[data-handle="' + $(this).val() + '"]').click();
        });
        types.first().click();

    })(jQuery);
</script>