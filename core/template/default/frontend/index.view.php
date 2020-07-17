<!doctype html>
<html>
<?php echo $this->getFrontEnd('head.php') ?>
<body>
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset content">
	<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
	<?php echo $this->getMastHead() ?>
	<?php echo $this->getFrontEnd('menu.php') ?>
	<?php echo $this->getPlugin('notifications') ?>
	<div class="col-2">
		<?php echo $this->getPlugin(((!empty($this->getSession('editor')) && $this->isAdmin())? 'editor' : 'layout')) ?>
	</div>
</div>
<div class="content">
	<?php echo $this->getFooter() ?>
</div>
    
<?php echo $this->getFrontEnd('foot.php') ?>
    
</body>
</html>