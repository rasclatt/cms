<div id="main-menu">
    <div id="company-logo" class="align-middle">
        <img src="/core/template/default/media/images/logo/u.png" alt="Nubersoft logo" />
    </div>
	<?php
	foreach($this->getHelper("Settings\Model")->getMenu('on', 'in_menubar') as $menu):
		if($menu['is_admin'] == 3) {
			if($this->isLoggedIn())
				continue;
		}
	?>
    
    <a href="<?php echo $menu['full_path'] ?>" data-menuid="<?php echo $menu['ID'] ?>" <?php if(strtolower($menu['full_path']) == $this->getPage('full_path')) echo ' class="active"' ?>><?php echo $menu['menu_name'] ?></a>
    
	<?php endforeach ?>
	
    <?php if($this->isLoggedIn()): ?>
	<a href="?action=logout">Sign out?</a>
	<?php endif ?>
        
    <?php echo $this->getPlugin('widget_storefront', 'counter.php') ?>
    
</div>