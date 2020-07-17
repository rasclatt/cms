<?php
$Form		=	$this->getHelper('nForm');
$Token		=	$this->getHelper('nToken');
$compData	=	$this->getPluginContent('component_content');
$ID			=	(!empty($compData['ID']))? $compData['ID'] : 'add';
$token		=	'component_'.$ID;
$ref_page	=	$compData['ref_page'];
?>
<div class="flexor">
    <div style="padding: 0.5em">
        <a href="?action=set_edit_mode&active=on" class="fx opacity-hover pointer"><i class="far fa-edit fa-2x"></i>&nbsp;More Options</a>
    </div>
</div>
<?php include(__DIR__.DS.'form.php') ?>

<style>
    .expander.mini-btn.dark {
        display: none !important;
    }
    .component-editor-form .nbr.component.tabber {
        min-height: 400px !important;
    }
</style>

<script>
    $(function(){
        let hideInputs  =   [
            'ref_page',
            'timestamp',
            'usergroup',
            'group_id',
            'cached',
            'page_order',
            'page_live',
            'delete'
        ];
        
        $.each(hideInputs, function(k, v){
           $('select[name=' + v + ']').parents('.nbr_form_input').hide();
           $('input[name=' + v + ']').parents('.nbr_form_input').hide();
        });
        
	   $('input[name="delete"]').on('click', function(e){
           if($(this).is(':checked')) {
               let conf =   confirm('Really delete?');
               if(!conf)
                   $(this).prop('checked', false);
           }
       });
    });
</script>