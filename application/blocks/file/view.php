<?php  defined('C5_EXECUTE') or die("Access Denied.");
$f = $controller->getFileObject();
$fp = new Permissions($f);
if ($f && $fp->canViewFile()) {
	$c = Page::getCurrentPage();
	if($c instanceof Page) {
		$cID = $c->getCollectionID();
	}

	?>
	<style>
		.related-file-block a {
			text-decoration: none;
		}
		.related-file-block a:hover {
			color: #3598dc;
		}
	</style>
	<div class="related-file-block">
		<a href="<?php echo ($forceDownload ? $f->getForceDownloadURL() : $f->getDownloadURL()); ?>"> <i class="fa fa-paperclip"></i> &nbsp; <?php echo stripslashes($controller->getLinkText()) ?></a>
	</div> <!-- END related-file-block -->


<?php }

$c = Page::getCurrentPage();
 if (!$f && $c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty File Block.')?></div>
<?php }
