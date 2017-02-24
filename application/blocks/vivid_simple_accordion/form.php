<?php   defined('C5_EXECUTE') or die("Access Denied.");
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
?>

<style type="text/css">
    .panel-heading { cursor: move; }
        .panel-heading .label-shell { margin-top: 5px; }
            .panel-heading .label-shell label { display: block; text-align: right; }
            .panel-heading .label-shell label i { float: left; margin-top: 3px; cursor: move; }
    .panel-body { display: none; }
    .item-summary { padding: 10px; }
    .item-summary.active { background: #efefef; }
    .item-detail { display: none; background: #efefef; padding: 10px; }
    .tab-pane { padding: 20px 0; }
    .item-shell {position: relative; padding-bottom: 0 !important;  }
    .redactor_editor {  padding: 20px;  }
</style>
<?php 
$addSelected = true;
?>
<p>
<?php  print Loader::helper('concrete/ui')->tabs(array(
    array('pane-items', t('Items'), $addSelected),
    array('pane-settings', t('Settings'))
));?>
</p>
<div class="ccm-tab-content" id="ccm-tab-content-pane-items">
        
    <div class="well">
        <?php  echo t('You can rearrange items if needed.'); ?>
    </div>
    
    <div class="items-container"></div>  
    
    <span class="btn btn-success btn-add-item"><?php  echo t('Add Item') ?></span>  
        
</div>
    
<div class="ccm-tab-content" id="ccm-tab-content-pane-settings">
           
    <div class="form-group">                    
        <label class="form-label"><?php  echo t('Use Framework Markup');?></label>
        <div class="well">
            <?php  echo t('If your theme uses the bootstrap framework, then select that. Otherwise, just choose none');?>
        </div>
        <?php  echo $form->select("framework",array(""=>t("None"), "bootstrap"=>t("Bootstrap")),$framework); ?>                 
    </div>
    <div class="form-group">                    
        <label class="form-label"><?php  echo t('Semantic Tag for Title');?></label>
        <?php  echo $form->select("semantic",array("h2"=>t("H2"), "h3"=>t("H3"), "h4"=>t("H4"), "span"=>t("Span"), "paragraph"=>t("Paragraph")),$semantic); ?>                 
    </div>    
        
</div>
    
<script type="text/template" id="item-template">
    <div class="item panel panel-default" data-order="<%=sort%>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3 label-shell">
                    <label for="title<%=sort%>"><i class="fa fa-arrows drag-handle"></i> <?php echo t('Title')?></label>
                </div>
                <div class="col-xs-5">
                    <input type="text" class="form-control" name="title[]" value="<%=title%>">    
                </div>
                <div class="col-xs-4 text-right">
                    <a href="javascript:editItem(<%=sort%>);" class="btn btn-edit-item btn-default"><?php echo t('Edit')?></a>
                <a href="javascript:deleteItem(<%=sort%>)" class="btn btn-delete-item btn-danger"><?php echo t('Delete')?></a>
                </div>
            </div>
        </div>
        <div class="panel-body form-horizontal"> 
            <div class="form-group">
                <label class="col-xs-3 control-label" for="description<%=sort%>"><?php echo t('Description:')?></label>
                <div class="col-xs-9">
                    <textarea class="redactor-content" name="description[]" id="description<%=sort%>"><%=description%></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label"><?php echo t('State')?></label>
                <div class="col-xs-9">
                    <select class="form-control" name="state[]">
                        <option value="open" <%= state=='open' ? 'selected' : '' %>><?php  echo t('Open');?></option>
                        <option value="closed" <%= state=='closed' ? 'selected' : '' %>><?php  echo t('Closed');?></option>
                    </select>
                </div>
            </div>     
        </div>
        <input class="item-sort" type="hidden" name="<?php  echo $view->field('sortOrder')?>[]" value="<%=sort%>"/>
    </div>
</script>

<script type="text/javascript">

//Edit Button
var editItem = function(i){
    $(".item[data-order='"+i+"']").find(".panel-body").toggle();
};
//Delete Button
var deleteItem = function(i) {
    var confirmDelete = confirm('<?php  echo t('Are you sure?') ?>');
    if(confirmDelete == true) {
        $(".item[data-order='"+i+"']").remove();
        indexItems();
    }
};
//Choose Image
var chooseImage = function(i){
    var imgShell = $('#select-image-'+i);
    ConcreteFileManager.launchDialog(function (data) {
        ConcreteFileManager.getFileDetails(data.fID, function(r) {
            jQuery.fn.dialog.hideLoader();
            var file = r.files[0];
            imgShell.html(file.resultsThumbnailImg);
            imgShell.next('.image-fID').val(file.fID)
        });
    });
};

//Index our Items
function indexItems(){
    $('.items-container .item').each(function(i) {
        $(this).find('.item-sort').val(i);
        $(this).attr("data-order",i);
    });
};

$(function(){
    
    //DEFINE VARS
    
        //use when using Redactor (wysiwyg)
        var CCM_EDITOR_SECURITY_TOKEN = "<?php  echo Loader::helper('validation/token')->generate('editor')?>";
        
        //Define container and items
        var itemsContainer = $('.items-container');
        var itemTemplate = _.template($('#item-template').html());
    
    //BASIC FUNCTIONS
    
        //Make items sortable. If we re-sort them, re-index them.
        $(".items-container").sortable({
            handle: ".panel-heading",
            update: function(){
                indexItems();
            }
        });
    
    //LOAD UP OUR ITEMS
        
        //for each Item, apply the template.
        <?php  
        if($items) {
            foreach ($items as $item) { 
        ?>
        itemsContainer.append(itemTemplate({
            //define variables to pass to the template.
            title: '<?php  echo addslashes($item['title']) ?>',
            
            //REDACTOR
            description: '<?php  echo str_replace(array("\t", "\r", "\n"), "", addslashes($item['description']))?>',
            
            state: '<?php echo $item['state']?>',            
            sort: '<?php echo $item['sortOrder'] ?>'
        }));
        <?php  
            }
        }
        ?>    
        
        //Init Index
        indexItems();

        //Init Redactor
        $('.redactor-content').redactor({
            minHeight: '200',
            'concrete5': {
                filemanager: <?php  echo $fp->canAccessFileManager()?>,
                sitemap: <?php  echo $tp->canAccessSitemap()?>,
                lightbox: true
            }
        });
        
    //CREATE NEW ITEM
        
        $('.btn-add-item').click(function(){
            
            //Use the template to create a new item.
            var temp = $(".items-container .item").length;
            temp = (temp);
            itemsContainer.append(itemTemplate({
                //vars to pass to the template
                title: '',
                description: '',
                state: '',
                
                sort: temp
            }));
            
            var thisModal = $(this).closest('.ui-dialog-content');
            var newItem = $('.items-container .item').last();
            thisModal.scrollTop(newItem.offset().top);
            
            //Init Redactor
            newItem.find('.redactor-content').redactor({
                minHeight: '100',
                'concrete5': {
                    filemanager: <?php  echo $fp->canAccessFileManager()?>,
                    sitemap: <?php  echo $tp->canAccessSitemap()?>,
                    lightbox: true
                }
            });
            
            //Init Index
            indexItems();
        });    

});
</script>