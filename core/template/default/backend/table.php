<?php
# Stop if not admin
if (!$this->isAdmin())
	return false;
$table = $this->getRequest('table');
$use = ($this->getGet('subaction') == 'interface') ? "admintools" : "table_view";
echo $this->getPlugin($use, ($this->getGet('subaction') == 'interface') ? DS . $table . DS . 'index.php' : '');