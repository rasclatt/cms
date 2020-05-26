<!doctype html>
<html>
<?php echo $this->getFrontEnd('head.php') ?>
<body>
<?php echo $this->getPlugin('adminbar') ?>
<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
<?php echo $this->getMastHead() ?>
<div class="content">
    <?php echo $this->getFrontEnd('menu.php') ?>
</div>
<?php echo $this->getPlugin('notifications') ?>
    
<div class="col-count-3 offset content">
    <div class="span-3 hero-blocks" id="hero-<?php echo $this->getPage('ID') ?>">
        
    </div>
	<div class="col-2">
		<?php echo $this->getPlugin(((!empty($this->getSession('editor')) && $this->isAdmin())? 'editor' : 'layout')) ?>
	</div>
</div>
<div class="content">
	<?php echo $this->getFooter() ?>
	<?php echo $this->getFrontEnd('foot.php') ?>
</div>
</body>
</html>