<?php $l =   $this->getPluginContent('layout_code') ?>

<?php if($this->isAdmin()): ?>
<!-- COMPONENT START -->
<div class="csm-tool-item code" data-compid="csm-item-<?php echo $l['ID'] ?>">
    
<?php endif ?>

	<?php echo $this->useMarkUp($this->dec($l['content'])) ?>

<?php if($this->isAdmin()): ?>
</div>
<!-- COMPONENT END -->
<?php endif ?>