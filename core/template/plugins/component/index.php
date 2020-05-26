<?php
$Form		=	$this->getHelper('nForm');
$Token		=	$this->getHelper('nToken');
$compData	=	$this->getPluginContent('component_content');
$ID			=	(!empty($compData['ID']))? $compData['ID'] : 'add';
$token		=	'component_'.$ID;
$ref_page	=	$compData['ref_page'];
?>
<div class="component-container">
	<div class="component-shade col-count-4">
		<div><a href="#editorid-<?php echo $compData['ID'] ?>" class="nTrigger nodrag close-btn" data-instructions='{"DOM":{"html":[" "], "sendto":["#editorid-<?php echo $compData['ID'] ?>"],"event":["click"]}}'>&times;</a></div>
		<div class="last-col">ID: <?php echo $compData['ID'] ?></div>
	</div>
	<div class="component-btns nodrag no-drag">
        
		<div>
			<?php echo $this->setPluginContent('add_component', array_merge($compData,['token' => $token]))->getPlugin('component', DS.'add.php') ?>
		</div>

		<div>
			<?php echo $Form->open() ?>
				<?php echo strip_tags($Form->fullhide(['name' => 'action', 'value' => 'edit_component']),'<input>') ?>
				<?php echo strip_tags($Form->fullhide(['name' => 'subaction', 'value' => 'duplicate']),'<input>') ?>
				<?php echo strip_tags($Form->fullhide(['name' => 'token[nProcessor]', 'value' => $Token->setToken($token)->getToken($token, false)]),'<input>') ?>
				<?php echo strip_tags($Form->fullhide(['name' => 'ref_page', 'value' => $this->getPage('unique_id')]),'<input>') ?>
				<?php echo strip_tags($Form->fullhide(['name' => 'parent_dup', 'value' => $compData['ID']]),'<input>') ?>
                <button style="background-color: #333; font-size: 1rem; color: #FFF; border: none; border-radius: 3px; min-width: 2rem; margin: 0; border: 1px solid #666; padding: 0.2rem" class=" fx opacity-hover pointer"><i class="far fa-clone pointer"></i></button>
			<?php echo $Form->close() ?>
		</div>
        
        <div style="padding: 0;">
            <a class="expander mini-btn dark margin-0" href="#" data-acton=".component-container" style="margin: 0 !important; position: relative; top: 4px;"><i class="fas fa-expand-arrows-alt"></i></a>
        </div>
        
        <div style="padding: 0.4em 0.5em 0 0.5em;">
            <a href="?action=set_edit_mode&active=off" class="fx opacity-hover pointer"><img src="/core/template/default/media/images/core/icn_view.png" style="max-height: 25px; width: auto;" class=" pointer"></a>
        </div>
	</div>
    
    <!-- start component form -->
    <div class="component-wrap">
        <div class="nodrag">
            <?php include(__DIR__.DS.'form.php') ?>
        </div>
    </div>
    <!-- end component form -->
    
</div>
<div class="component-shade">&nbsp;</div>

<script>
    $(function(){
	   $('input[name="delete"]').on('click', function(e){
           if($(this).is(':checked')) {
               let conf =   confirm('Really delete?');
               if(!conf)
                   $(this).prop('checked', false);
           }
       });
    });
</script>