<?php 
$name = (method_exists($this, 'getPluginContent'))? $this->getPluginContent('btn_name') : false;
?>
<div class="admin-plugin-btn" id="admin-plugin-button-file-editor">
    <a href="?load=<?php echo basename(__DIR__) ?>" class="pointer fx opacity-hover standard"><i class="far fa-hdd fa-2x pointer"></i><br /><?php echo (!empty($name))? $name : 'Files/Folders' ?></a>
</div>
