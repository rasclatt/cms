<?php
use \Nubersoft\ {
	nForm as Form,
	nToken
};
$Form		=	new Form;
$Token		=	new nToken;
$compData	=	$this->getPluginContent('add_component');
$token		=	(!empty($compData['token']))? $compData['token'] : 'component_add';
$type		=	(!empty($compData['component_type']))? $compData['component_type'] : 'code';

?>
<?php echo $Form->open() ?>
	<?php echo strip_tags($Form->fullhide(['name' => 'action', 'value' => 'edit_component']),'<input>') ?>
	<?php echo strip_tags($Form->fullhide(['name' => 'subaction', 'value' => 'add_new']),'<input>') ?>
	<?php echo strip_tags($Form->fullhide(['name' => 'token[nProcessor]', 'value' => $Token->setToken($token)->getToken($token, false)]),'<input>') ?>
	<?php echo strip_tags($Form->fullhide(['name' => 'ref_page', 'value' => ($compData['ref_page'])?? null]),'<input>') ?>
	<?php echo strip_tags($Form->fullhide(['name' => 'parent_type', 'value' => $type]),'<input>') ?>
    <button style="background-color: #333; font-size: 1rem; color: #FFF; border: none; border-radius: 3px; min-width: 2rem; margin: 0; border: 1px solid #666; padding: 0.2rem" class=" fx opacity-hover pointer"><i class="far fa-file pointer"></i></button><!--<?php echo strip_tags($Form->submit(['value' => 'ADD'.((empty($compData))? ' COMPONENT' : '' ), 'class' => ((empty($compData))? 'medi' : 'mini' ).'-btn dark no-margin']),'<input>') ?>-->
<?php echo $Form->close() ?>