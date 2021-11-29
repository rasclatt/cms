<!doctype html>
<html <?php if($this->isAdmin()) echo 'id="admin-view-mode"' ?>>
<?php echo $this->getFrontEnd('head.php') ?>
<body>
    <?php echo $this->getPlugin('adminbar') ?>
    <?php echo $this->getPlugin('editor', DS.'page_editor.php') ?>
    <?php echo $this->getMastHead() ?>
    <div>
        <?php echo $this->getFrontEnd('menu.php') ?>
    </div>
    <div class="col-count-3 offset content">
        <div class="span3 hero-blocks rel" id="hero-<?php echo $this->getPage('ID') ?>">
            <div class="abs-auto top-0 left-0 right-0 margin-top-1">
                <?php echo $this->getPlugin('notifications') ?>
            </div>
        </div>
        <div class="start2 rel">
            <?php echo $this->getPlugin(((!empty($this->getSession('editor')) && $this->isAdmin())? 'editor' : 'layout')) ?>
        </div>
    </div>
    <div class="content">
        <?php echo $this->getFooter() ?>
    </div>

    <?php echo $this->getFrontEnd('foot.php') ?>
</body>
</html>