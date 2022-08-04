<!doctype html>
<html id="admintools">
<?php echo $this->getFrontEnd('head.php') ?>
<body class="edit-mode">
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset" style="grid-template-rows: auto 1fr !important;">
	<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
	<div class="start2">
        <?php echo $this->getPlugin('notifications') ?>
		<?php echo $this->getPlugin('editor') ?>
	</div>
</div>
<div id="loadspot-modal"></div>
</body>
</html>