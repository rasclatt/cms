<!doctype html>
<html id="admintools">
<?php echo $this->getBackEnd('head.php') ?>
<body>

<section id="admin-interface">
	<div class="span2">
		<?php echo $this->getPlugin('adminbar') ?>
	</div>
	<div id="admin-content-wrap" class="span2">
		<div id="admin-sidebar">
			<?php echo $this->getPlugin('adminbar', DS.'sidebar.php') ?>
		</div>
		<div>
            <div class="abs-auto top-0 left-0 right-0 margin-top-1 pad-top-2 lvl-5">
                <?php echo $this->getPlugin('notifications') ?>
            </div>
			<div id="admin-content">
				<?php if($this->getPageByType('transtool') == $this->getPage('full_path')): ?>
                    <?php echo $this->getBackEnd('translation-engine.php') ?>
                <?php else: ?>
    				<?php echo $this->getBackEnd('interface.php') ?>            
                <?php endif ?>
			</div>
		</div>
	</div>
</section>

<section class="tinted-black">
    <?php echo $this->getFooter() ?>
</section>

<div id="loadspot-modal"></div>
</body>
</html>