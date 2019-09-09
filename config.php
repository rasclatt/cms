<?php
# Includes application defaults
require(__DIR__.DIRECTORY_SEPARATOR.'defines.php');
# Include client defines
if(is_file($client_defines = NBR_CLIENT_DIR.DS.'defines.php')) {
	include_once($client_defines);
}
# Include composer if set
if(is_file($vendor = NBR_ROOT_DIR.DS.'vendor'.DS.'autoload.php')) {
	include_once($vendor);
}
# Create localized autoloader
spl_autoload_register(function($class){
	# Include if found in general
	if(is_file($class = str_replace(DS.DS, DS, NBR_ROOT_DIR.DS.'vendor'.DS.str_replace('\\', DS, $class).'.php'))) {
		include_once($class);
	}
	# See if the class is a nubersoft
	elseif(is_file($class = str_replace(DS.DS, DS, NBR_ROOT_DIR.DS.'vendor'.DS.'rasclatt'.DS.'nubersoft'.DS.'src'.DS.str_replace('\\', DS, $class).'.php'))) {
		include_once($class);
	}
});