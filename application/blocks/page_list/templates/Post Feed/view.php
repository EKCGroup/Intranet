<?php defined('C5_EXECUTE') or die("Access Denied.");

$th = Loader::helper('text');
$c = Page::getCurrentPage();
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.') ?></div>
<?php } else { ?>

    <div class="post-feed">
        <div class="ccm-block-page-list-wrapper">

            <div class="ccm-block-page-list-pages">

                <?php
                $includeEntryText = false;
                if ($includeName || $includeDescription || $useButtonForLink) {
                    $includeEntryText = true;
                }

                foreach ($pages as $page):

                    // Prepare data for each page being listed...
                    $buttonClasses = 'ccm-block-page-list-read-more';
                    $entryClasses = 'ccm-block-page-list-page-entry';
                    $title = $th->entities($page->getCollectionName());
                    $url = ($page->getCollectionPointerExternalLink() != '') ? $page->getCollectionPointerExternalLink() : $nh->getLinkToCollection($page);
                    $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
                    $target = empty($target) ? '_self' : $target;
                    $description = $page->getCollectionDescription();
                    $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
                    $description = $th->entities($description);
                    $thumbnail = false;
                    if ($displayThumbnail) {
                        $thumbnail = $page->getAttribute('thumbnail');
                    }
                    if (is_object($thumbnail) && $includeEntryText) {
                        $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
                    }

                    $date = $dh->formatDateTime($page->getCollectionDatePublic(), true);
                ?>

                    <div class="<?php echo $entryClasses ?>">

                        <?php if ($includeEntryText): ?>
                            <div class="ccm-block-page-list-page-entry-text">

                                <?php if ($includeName): ?>
                                    <div class="ccm-block-page-list-title">
                                        <a href="<?php echo $url ?>" target="<?php echo $target ?>"><h3><?php echo $title ?></h3></a>
                                    </div>
                                <?php endif; ?>
                                
                                    <?php if ($includeDate): ?>
                                        <div class="ccm-block-page-list-date">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $date ?></div>
                                    <?php endif; ?>

                                    <div class="post-owner"> 
                                        <?php
                                            echo 'posted by ';
                                            $ownerID = $page->getCollectionUserID();
                                            $ui = UserInfo::getByID($ownerID);
                                            $ownerName = $ui->getUserName();
                                            $name = $ui->getAttribute('user_fullname');
                                            if ($name):
                                                echo $name;
                                            else :
                                                echo $ownerName;
                                            endif;
                                        ?>
                                    </div><br>

                                    <?php if (is_object($thumbnail)): ?>
                                    <div class="ccm-block-page-list-page-entry-thumbnail">
                                        <?php
                                        $img = Core::make('html/image', array($thumbnail));
                                        $tag = $img->getTag();
                                        $tag->addClass('bulletin-img');
                                        print $tag;
                                        ?>
                                    </div>
                                <?php endif; ?>

                                    <?php if ($includeDescription): ?>
                                    <div class="ccm-block-page-list-description post-description">
                                    <?php echo $description ?>
                                    </div>
                                <?php endif; ?>

                                <div class="post-categorie">
                                    <?php
                                    echo 'Post Categorie: ';
                                    $parent = page::getByID($page->getCollectionParentID());
                                    print $parent->getCollectionName();
                                    ?>
                                </div>

                                 <?php if ($useButtonForLink): ?>
                                    <div class="ccm-block-page-list-page-entry-read-more">
                                        <a href="<?php echo $url ?>" class="<?php echo $buttonClasses ?>"><?php echo $buttonLinkText ?></a>
                                    </div>
                                <?php endif; ?>

                            </div>
        <?php endif; ?>
                    </div>

    <?php endforeach; ?>
            </div>

            <?php if (count($pages) == 0): ?>
                <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage) ?></div>
    <?php endif; ?>

        </div><!-- end .ccm-block-page-list -->
    </div> <!-- END post-feed -->

    <?php if ($showPagination): ?>
        <?php echo $pagination; ?>
    <?php endif; ?>

<?php } ?>
