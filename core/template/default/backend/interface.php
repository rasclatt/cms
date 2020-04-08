<?php
if(!$this->isAdmin())
	return false;
$table	=	$this->getRequest('table');
if(!empty($table)):
	$use	=	($this->getGet('subaction') == 'interface')? "admintools" : "table_view";
	echo $this->getPlugin($use, ($this->getGet('subaction') == 'interface')? DS.$table.DS.'index.php' : '');

elseif($this->getGet('load') == 'coreinstaller'): ?>

<h2>Installer / Update</h2>
<p>Use this installer to update the core system software or the Nubersoft core framework.</p>

<?php include(NBR_DOMAIN_ROOT.DS.'core'.DS.'installer'.DS.'html'.DS.'update_software.php') ?>

<?php else: ?>

<h2>Dashboard</h2>
<p>Welcome to your dashboard.</p>
<div class="col-count-5 lrg-3 med-2 sml-1">
<?php
	
	foreach($this->getDataNode('plugins')['paths'] as $path) {
		if(!is_dir($path))
			continue;
		
		foreach(scandir($path) as $pdir) {
			if(in_array($pdir, ['.','..']))
				continue;
			
			if(!is_file($ui = $path.DS.$pdir.DS.'admin_ui.php'))
				continue;
		?>
	
	<div class="admin-plugin" id="admin-plugin-<?php echo $pdir ?>">
		<?php include($ui) ?>
	</div>
		
		<?php
		}
	}
	?>
</div>
<?php
	 
endif;