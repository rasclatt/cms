<?php
$settings	=	$this->getPluginContent('translator');
if(empty($settings))
	return false;

extract($settings);

if(!empty($id)) {
	$text	=	$this->getComponentBy(['category_id' => 'translator', 'title' => $id]);
	if($text)
		$text	=	$this->dec($text[0]['content']);
}
$min    =   ($height)?? '300px';
$height =   ($h)?? '300px';
?>

<?php if(empty(\Nubersoft\Localization\View::isEditableMode())): ?>

<?php echo nl2br((!empty($text))? $this->getHelper('nMarkUp')->useMarkUp($text) : $default) ?>

<?php if($is_admin):?>
<a href="?action=edit_translator&subaction=on" class="pointer opacity-hover edit-button" title="Edit text"><i class="far fa-edit fa-2x pointer" role="button"></i><span class="button small gray">Edit</span></a>
<?php endif ?>

<?php else: ?>

<div class="text-editor-translator">
    <p style="color: #333; background-color: rgba(200,200,200, 0.3); margin: 0; padding: 0.35em; border-radius: 4px;"><?php if(!empty($id)) echo 'Block ID: <strong>'. $id; ?></strong> / Localization: <code><?php echo $this->getSession('locale') ?> / <?php echo $this->getSession('locale_lang') ?></code><?php if(!empty($label)) echo ' '.$label ?></p>

    <form class="<?php echo $class = (!empty($class))? $class : 'nbr_ajax_form' ?>"<?php if(!empty($id)): ?> data-instructions='{"action":"wb_create_translator"}'<?php endif ?>>
        <input type="hidden" name="action" value="wb_create_translator" />
        <input type="hidden" name="title" value="<?php echo $id ?>" />
        <?php if(!empty($ref_page)): ?>
        <input type="hidden" name="ref_page" value="<?php echo $ref_page ?>" />
        <?php endif ?>
        <?php if(!empty($inputs)):
            foreach($inputs as $key => $value): ?>

        <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>" />

            <?php endforeach ?>
        <?php endif ?>
        <textarea class="nbr textarea" name="description" style="min-height: <?php echo $min ?>;"><?php echo (!empty($text))? $text : $default ?></textarea>
        <div class="pad-top-xsmall pad-bottom-xsmall">
            <input type="submit" value="SAVE" class="button" />
            <?php if($is_admin):?>
            <div style="float: right;">
                <a href="?action=edit_translator&subaction=off" class="pointer opacity-hover edit-button" title="Edit text"><i class="far fa-edit fa-2x pointer" role="button"></i><i class="far fa-edit fa-2x pointer" role="button"></i><span class="button small gray">DONE</span></a>
            </div>
        </div>
    <?php endif ?>
    </form>
</div>
<?php endif ?>