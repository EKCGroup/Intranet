<?php
defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();

if ($c instanceof Page) {
    $cID = $c->getCollectionID();
}
?>

<?php if ($displaySetTitle && $filesetname = $controller->getFileSetName()) { ?>
    <h3><?php echo $filesetname; ?></h3>
<?php }

if (!empty($files)) { ?>
   
    <table class="table table-striped sortable table-hover">
        <thead>
        <th><?php echo t('Name'); ?></th>
        <?php
            if ($extension == 'brackets') {
                echo '<th id="file">' . t('Type') . '</th>';
            }
            if ($displaySize) {
                echo '<th id="size">' . t('File Size') . '</th>';
            }
            if ($displayDateAdded) {
                echo '<th id="date">' . t('Upload Date') . '</th>';
            }
            if ($forceDownload) {
                echo '<th id="download">' . t('Download') . '</th>';
            }
        ?>
        </thead>
        <tbody>
            <?php
            foreach ($files as $f) {

                $fv = $f->getApprovedVersion();
                $filename = $fv->getFileName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                $url = $f->getDownloadURL();

                if ($titleOverride) {
                    $title = $titleOverride;
                } else {

                    $title = $f->getTitle();

                    if ($extension == 'hide') {
                        if (strlen($title) - strlen($ext) == strrpos($title, $ext)) {
                            $title = pathinfo($title, PATHINFO_FILENAME);
                        }
                    } elseif ($extension == 'brackets') {

                        if (strlen($title) - strlen($ext) == strrpos($title, $ext)) {
                            $title = pathinfo($title, PATHINFO_FILENAME);
                        }
                    }
                    if ($replaceUnderscores) {
                        $title = str_replace('_', ' ', $title);
                    }
                    if ($uppercaseFirst) {
                        $title = ucfirst(strtolower($title));
                    }
                }

                if (str_replace(',', '', $fv->getSize()) >= 1000) {
                    $filesize_IF = $fv->getSize() * 1 . ' MB';
                } else {
                    $filesize_IF = round($fv->getSize(), 1) . ' KB';
                }
            ?>

                <tr id="item">
                    <td id="file">&nbsp;<i class="fa fa-paperclip"></i> &nbsp;&nbsp; 
                        <a href=" <?php echo $url; ?>">
                            <?php echo $title; ?>
                        </a>
                    </td>

                    <?php
                    if ($extension == 'brackets') {
                        echo '<td>' . $ext . '</td>';
                    }

                    if ($displaySize) {
                        echo '<td id="size">&nbsp;' . $filesize_IF;
                    } echo '</td>';


                    if ($displayDateAdded) {
                        $dh = Core::make('helper/date');
                        $originaldate = $dh->formatDate($fv->getDateAdded());
                        $newdate = explode('/', $originaldate);

                        $u = new User();
                        global $u;

                        if ($u->getUserName() == 'david') {
                            echo '<td id="date">&nbsp;20' . $newdate['2'] . '/' . $newdate['0'] . '/' . $newdate['1'] . '</td>';
                        } else {
                            echo '<td id="date">&nbsp;' . $newdate['1'] . '/' . $newdate['0'] . '/20' . $newdate['2'] . '</td>';
                        }
                    }
                    if ($forceDownload) {
                        echo '<td id="download"> <a href="' . $url = $f->getForceDownloadURL() . '" style="text-decoration: none"> &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-download"></i> </a> </td>';
                    }
                    ?>
                </tr>
        <?php } ?>
        <tbody>
    </table>
<?php } ?>

<?php if ($pagination):
    echo $pagination;
endif; ?>

<style>
    div#datatable_paginate, div#datatable_length, div#datatable_filter {
        display: none;
    }
</style>