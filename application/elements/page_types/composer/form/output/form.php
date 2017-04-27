<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Page\Type\Composer\FormLayoutSet as PageTypeComposerFormLayoutSet;
use \Concrete\Core\Page\Type\Composer\FormLayoutSetControl as PageTypeComposerFormLayoutSetControl;
$fieldsets = PageTypeComposerFormLayoutSet::getList($pagetype);
$cmp = new Permissions($pagetype);
// $targetPage comes from renderComposerOutputForm($page, $targetPage); only
// set in dialog page.

$targetParentPageID = 0;
if (is_object($targetPage)) {
    $targetParentPageID = $targetPage->getCollectionID();
}

?>

<div class="ccm-ui">

<div class="alert alert-info" style="display: none" id="ccm-page-type-composer-form-save-status"></div>

    <style>.form-group.ccm-composer-url-slug {display:none}</style>
<?php $u = new User(); if($u->inGroup(Group::getByName('Administrators'))){ ?>
    <style>.form-group.ccm-composer-url-slug {display:block !important}</style>
<?php } ?>

    <input type="hidden" name="ptID" value="<?php echo $pagetype->getPageTypeID()?>" />

<?php foreach($fieldsets as $cfl) { ?>
	<fieldset>
		<?php if ($cfl->getPageTypeComposerFormLayoutSetDisplayName()) { ?>
			<legend><?php echo $cfl->getPageTypeComposerFormLayoutSetDisplayName()?></legend>
		<?php } ?>
		<?php if ($cfl->getPageTypeComposerFormLayoutSetDisplayDescription()) { ?>
			<span class="help-block"><?php echo $cfl->getPageTypeComposerFormLayoutSetDisplayDescription()?></span>
		<?php } ?>
		<?php $controls = PageTypeComposerFormLayoutSetControl::getList($cfl);

		foreach($controls as $con) {
			if (is_object($page)) { // we are loading content in
				$con->setPageObject($page);
			}
            $con->setTargetParentPageID($targetParentPageID);
            ?>
			<?php $con->render(); ?>
		<?php } ?>

	</fieldset>

<?php } ?>

</div>
