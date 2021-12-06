<?php
use \Nubersoft\ErrorMessaging\Controller as Errors;
use \NubersoftCms\Model\AdminTools;

# Stop if not admin
if (!$this->isAdmin())
	return false;
# Get errors
$Errors = new Errors;
# Go to the table viewer
if (!empty($this->getRequest('table'))):
		echo $this->getBackEnd('table.php');
	return false;
# Do the installer
elseif (!empty($this->getGet('load'))):
	switch ($this->getGet('load')) {
		# Install the default multi-lingual messages
		case ('installmsg'):
			$Errors->installDefaultCodes();
			break;
		# Update the core software
		case ('coreinstaller'):
			echo $this->getBackEnd('installer.php');
			return false;
		default:
			$plugin = AdminTools::plugins($this->getGet('load'));
			# If no layout, notify
			if($plugin->count == 0)
				throw new \Exception('No such plugin exists.', 404);
			if(!empty($plugin->plugins[$this->getGet('load')]->ui)) {
				echo $this->getPlugin($this->getGet('load'), 'admin_ui.php');
				return false;
			}
	}
endif;
# Show the default page
echo $this->getBackEnd('dashboard.php');