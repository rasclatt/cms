<?php
use \Nubersoft\nQuery;
# Stop if not admin
if (!$this->isAdmin())
	return false;
# Store the table
$table = $this->getRequest('table');
# Get the tables from db
$tablesAllowed = array_map(function($v) {
	return $v[key($v)];
}, (new nQuery)->query("SHOW TABLES")->getResults());
# If not allowed, stop
if(!in_array($table, $tablesAllowed))
	throw new \Exception('Invalid request.');
# Fetch table
$use = ($this->getGet('subaction') == 'interface') ? "admintools" : "table_view";
echo $this->getPlugin($use, ($this->getGet('subaction') == 'interface') ? DS . $table . DS . 'index.php' : '');