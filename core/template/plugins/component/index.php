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
				<?php echo strip_tags($Form->submit(['value' => 'DUPLICATE', 'class' => 'mini-btn dark no-margin']),'<input>') ?>
			<?php echo $Form->close() ?>
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