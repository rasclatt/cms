
    <div class="component-add-new pad-bottom-xsmall"><?php echo $this->getPlugin('component', DS.'add.php') ?></div>
    
    <div class="col-count-5 gapped lrg-3 gapped med-2 gapped sml-1 component-library-container">
	<?php
	$layout	=	@$this->Settings_Page_View()->create($this->getPage('unique_id'), 'editor');
	if(!empty($layout))
        echo $layout;
    ?>
	
</div>

<script>
$( function() {
    $('.editor-title img').on('click', function(){
        AjaxEngine.ajax({
            action: "viewblocklayout",
            component: $(this).parents('.editor-title').data('itemid')
        }, function(response){
            default_action($(this), response);
        });
    });
    
    
    $(".component-library-container").sortable({
        cancel: '.editor-title,.edit-btn,.component-editor,.container-off',
        update: function(event, ui) {
            var itms    =   [];
            var i   =   0;
            $.each($('.item-container-editor-code,.item-container-editor-code_cached'), function(k,v){
                i++;
                itms.push({
                    "component": $(v).data('itemid'),
                    "page_order": i
                });
            });
            
            AjaxEngine.ajax({"action":"updatecomporder", data: itms}, function(response){
                default_action($(this), response);
            });
        }
    });
    
    $(".component-library-container" ).disableSelection();
    
    $('.active-status').on('click', function(){
        var compid = $(this).parents('.component-parent').data('itemid');
        
        AjaxEngine.ajax({"action":"updatecompactive", data: {
            component: compid
        }}, function(response){
            var resp    =   JSON.parse(response);
            $('#comp-' + compid + ' > div:first-child img.active-status').attr('src', "/core/template/default/media/images/core/led_" + resp.mode + ".png");
            
            var statborder  =   (resp.mode == 'on')? 'off' : 'on';
            
            $('#comp-' + compid).removeClass('container-' + statborder).addClass('container-' + resp.mode);
        });
        
    });
    
});
</script>