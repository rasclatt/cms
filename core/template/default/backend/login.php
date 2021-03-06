<!doctype html>
<html class="content">
<?php echo $this->getFrontEnd('head.php') ?>
<body class="edit-mode login" >
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset content">
	<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
	<?php echo $this->getPlugin('notifications') ?>
	<div class="start2" id="admin-container">
		<div id="admin-login">
			
			<div<?php if(!$this->siteLogoActive()): ?> class="col-count-3"<?php else: ?> style="padding: 0 2em 2em 2em;"<?php endif ?>>
				<a href="<?php echo $this->localeUrl() ?>" id="admin-logo" class="start2"><?php echo $this->getSiteLogo('/core/template/default/media/images/logo/u.png') ?></a>
			</div>
			<?php echo $this->getPlugin('login') ?>
		</div>
	</div>
</div>
<div class="content col-count-3 offset" id="footer-container"> 
	<div class="start2 white align-center">&copy; <?php echo $this->localeUrl() ?> <?php echo date('Y') ?>. All rights reserved.</div>
</div>
</body>
</html>