<header id="main-menu" class="header-area">
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
    
    <a href="<?php echo $menu['full_path'] ?>" data-menuid="<?php echo $menu['ID'] ?>" class="align-middle <?php if(strtolower($menu['full_path']) == $this->getPage('full_path')) echo 'active' ?> trans-cls" data-trans="<?php echo preg_replace('/[^\d\w]/', '', strtolower($menu['menu_name'])) ?>"><?php echo $menu['menu_name'] ?></a>
    
	<?php endforeach ?>
	
    <?php if($this->isLoggedIn()): ?>
	<a href="?action=logout" class="align-middle trans-cls" data-trans="signout">Sign out?</a>
	<?php endif ?>
    
    <?php echo $this->getPlugin('widget_locale', 'countryselector.php') ?>
    <?php echo $this->getPlugin('widget_storefront', 'counter.php') ?>
    
</header>

<div id="mobile-menu">
    <div id="company-logo" class="align-middle">
        <img src="/core/template/default/media/images/logo/u.png" alt="Nubersoft logo" />
    </div>
    <div class="mobile-nav-wrapper">
        <div class="mobile-menu-container">
            <div class="align-left pad-top-1 pad-left-1">
                <label for="mobile-m<?php echo $mr = rand() ?>" class="menu-toggler" role="button"><i class="fas fa-bars fa-2x"></i></label>
            </div>
            <input type="checkbox" name="mobile-menu" id="mobile-m<?php echo $mr ?>" />
            <div class="mobile-menu-wrap">
                <?php
                foreach($this->getHelper("Settings\Model")->getMenu('on', 'in_menubar') as $menu):
                    if($menu['is_admin'] == 3) {
                        if($this->isLoggedIn())
                            continue;
                    }
                ?>

                <a href="<?php echo $menu['full_path'] ?>" data-menuid="<?php echo $menu['ID'] ?>" class="align-middle <?php if(strtolower($menu['full_path']) == $this->getPage('full_path')) echo 'active' ?> trans-cls" data-trans="<?php echo preg_replace('/[^\d\w]/', '', strtolower($menu['menu_name'])) ?>"><?php echo $menu['menu_name'] ?></a>

                <?php endforeach ?>

                <?php if($this->isLoggedIn()): ?>
                <a href="?action=logout" class="align-middle trans-cls" data-trans="signout">Sign out?</a>
                <?php endif ?>
            </div>
        </div>
        <div class="flexor">
            <?php echo $this->getPlugin('widget_locale', 'countryselector.php') ?>
            <?php echo $this->getPlugin('widget_storefront', 'counter.php') ?>
        </div>
    </div>
</div>