<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<script type="text/javascript">
$(function() {
	$('i.icon-question-sign').parent().tooltip();
});
</script>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h1 class="page-header"><?php echo t('Account')?></h1>
        <p><?php echo t('You are currently logged in as <strong>%s</strong>', $profile->getUserDisplayName())?>.</p>


        <?php foreach($pages as $p) { ?>
            <hr/>
            <div>
                <a href="<?php echo $p->getCollectionLink()?>"><?php echo h(t($p->getCollectionName()))?></a>
                <?php
                $description = $p->getCollectionDescription();
                if ($description) { ?>
                    <p><?php echo h(t($description))?></p>
                <?php } ?>
            </div>
        <?php } ?>


        <?php
        $profileURL = $profile->getUserPublicProfileURL();
        if ($profileURL) { ?>
            <hr/>
            <div>
                <a href="<?php echo $profileURL?>"><?php echo t("View Public Profile")?></a>
                <p><?php echo t('View your public user profile and the information you are sharing.')?></p>
            </div>


        <?php } ?>

    </div>
</div>
