<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$c = Page::getCurrentPage();
	if (!$content && is_object($c) && $c->isEditMode()) { ?>
		<div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Content Block.')?></div> 
	<?php } else { ?>
            <div class="bulletin-content"><style>input#unsubscribe, input#subscribe{margin:-89px -20px 0 0 !important;}</style> <?php
		print $content;
		?> </div> <!-- END bulletin-content --> <?php
	}