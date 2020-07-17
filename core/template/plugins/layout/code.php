<?php $l =   $this->getPluginContent('layout_code') ?>

<?php if($this->isAdmin()): ?>
    <?php $allowed = ($this->userGet('usergroup') <= 1 && !\Nubersoft\Localization\View::isEditableMode()); ?>
<!-- COMPONENT START -->
    <?php if($allowed): ?>
<div class="csm-tool-item code" data-compid="csm-item-<?php echo $l['ID'] ?>">
    <div class="edit-btn-tools hide nTrigger pointer" role="button" data-instructions='{"action":"edit_component_modal","data":{"deliver":{"ID":"<?php echo $l['ID'] ?>"}}}'>EDIT</div>
    <?php endif ?>
    
<?php endif ?>

	<?php echo $this->useMarkUp($this->dec($l['content'])) ?>

<?php if($this->isAdmin()): ?>
    <?php if($allowed): ?>
</div>
<!-- COMPONENT END -->
    <?php endif ?>
<?php endif ?>