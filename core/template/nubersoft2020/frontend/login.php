<!doctype html>
<html>
<?php echo $this->getFrontEnd('head.php') ?>
<body class="<?php if($this->getSession('editor')) echo 'edit-mode' ?>">
    <?php echo $this->getPlugin('adminbar') ?>
	<?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
	<?php echo $this->getFrontEnd('menu.php') ?>
    
    <div class="col-count-3 offset content">
        <div class="start2 rel pad-top-2">
            <div class="abs-auto left-0 right-0 top-0 margin-top-1">
                <?php echo $this->getPlugin('notifications') ?>
            </div>
            <div<?php if(!$this->siteLogoActive()): ?> class="col-count-3"<?php else: ?> style="padding: 0 2em 2em 2em;"<?php endif ?>>
                <a href="<?php echo $this->localeUrl() ?>" id="admin-logo" class="start2"><?php echo $this->getSiteLogo(false, true) ?></a>
            </div>
            <div class="login-dialogue-wrapper align-middle">
                <div class="login-dialogue-container">
                    <div class="align-middle">
                        <?php echo $this->getPlugin('login') ?>
                        <?php echo $this->getPlugin('sign_up') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(!$this->getSession('editor')) : ?>
    <div class="content">
        <?php echo $this->getFooter() ?>
        <?php echo $this->getFrontEnd('foot.php') ?>
    </div>
    <?php endif ?>
</body>
</html>