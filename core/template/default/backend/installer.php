<?php
# Stop if not admin
if (!$this->isAdmin())
	return false;
?>
<h2>Installer / Update</h2>
<p>Use this installer to update the core system software or the Nubersoft core framework.</p>
<?php include(NBR_DOMAIN_ROOT . DS . 'core' . DS . 'installer' . DS . 'html' . DS . 'update_software.php') ?>
