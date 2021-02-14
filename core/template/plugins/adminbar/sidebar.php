
<div class="admin-left-logo margin-bottom-2">
    <a href="<?php echo $this->localeUrl($this->getPage('full_path')) ?>" class="pointer margin-bottom-2"><?php echo $this->getSiteLogo(URL_CORE_IMAGES.'/logo/nubersoft.png') ?></a>
</div>

<?php
if($this->userGet('usergroup') > 1)
    return false;
?>
<div class="icn-dashboard">
    <a href="<?php echo $this->getAdminPage() ?>" class="sidebar"><span>Dashboard</span></a>
</div>

<div class="icn-globe">
    <a href="#" class="sidebar nTrigger<?php if($this->getGet('loadpage') == 'load_settings_page' && $this->getGet('subaction') == 'global') echo ' nListener' ?>" data-instructions='{"DOM":{"sendto":["#admin-content"],"html":["<img src=\"/core/template/default/media/images/ui/loader.gif\" class=\"loader\" />"],"event":["click"]},"action":"load_settings_page","data":{"deliver":{"subaction":"global"}}}'><span>Global Settings</span></a>
</div>

<div class="icn-head">
    <a href="#" class="sidebar nTrigger<?php if($this->getGet('loadpage') == 'load_settings_page' && $this->getGet('subaction') == 'header') echo ' nListener' ?>" data-instructions='{"DOM":{"sendto":["#admin-content"],"html":["<img src=\"/core/template/default/media/images/ui/loader.gif\" class=\"loader\" />"],"event":["click"]},"action":"load_settings_page","data":{"deliver":{"subaction":"header"}}}'><span>Header Settings</span></a>
</div>
    
<div class="icn-foot">
    <a href="#" class="sidebar nTrigger<?php if($this->getGet('loadpage') == 'load_settings_page' && $this->getGet('subaction') == 'footer') echo ' nListener' ?>" data-instructions='{"DOM":{"sendto":["#admin-content"],"html":["<img src=\"/core/template/default/media/images/ui/loader.gif\" class=\"loader\" />"],"event":["click"]},"action":"load_settings_page","data":{"deliver":{"subaction":"footer"}}}'><span>Footer Settings</span></a>
</div>

<div class="icn-plugin">
    <a href="#" class="sidebar nTrigger<?php if($this->getGet('loadpage') == 'load_settings_page' && $this->getGet('subaction') == 'plugins') echo ' nListener' ?>" data-instructions='{"DOM":{"sendto":["#admin-content"],"html":["<img src=\"/core/template/default/media/images/ui/loader.gif\" class=\"loader\" />"],"event":["click"]},"action":"load_settings_page","data":{"deliver":{"subaction":"plugins"}}}'><span>Widgets</span></a>
</div>

<div class="icn-user">
    <a href="?table=users&subaction=interface" class="sidebar"><span>Users</span></a>
</div>

<?php
foreach($this->getDataNode('plugins')['paths'] as $path) {
	if(!is_dir($path))
		continue;

	foreach(scandir($path) as $pdir) {
		if(in_array($pdir, ['.','..']))
			continue;

		if(!is_file($ui = $path.DS.$pdir.DS.'admin_sidebar.php'))
			continue;
		
		include($ui);
	}
}
?>