<!doctype html>
<html id="admintools">
<?php echo $this->getFrontEnd('head.php') ?>
<body class="edit-mode">
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset content" style="grid-template-rows: auto 1fr !important;">
	<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
	<div class="start2 rel">
        <div class="abs-auto left-0 right-0">
            <?php echo $this->getPlugin('notifications') ?>
        </div>
		<?php echo $this->getPlugin('editor') ?>
	</div>
</div>
<div id="loadspot-modal"></div>
</body>
</html>