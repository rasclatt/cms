<?php
namespace Nubersoft;
#check if cron job set
if(!empty($argv[1])) {
	# Set the request manually
	$_REQUEST	=	[];
	parse_str($argv[1], $_REQUEST);
}
# Add our application config
require(realpath(__DIR__.DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR.'config.php');
# Create instance of the main class
$Application	=	nApp::call();

try {
	# Start buffering
	ob_start();
	# Allow a custom index page instead of the default
	if(is_file($index = NBR_CLIENT_DIR.DS.'index.php')) {
		include($index);
	}
	else {
		# Create a container application
		$Application->createContainer(function(
			nApp $nApp,
			nSession $Session,
			nGlobal\Observer $nGlobal,
			nAutomator\Controller $AutomatorController,
			nRouter $Router,
			Settings $Settings
		){
			if(is_file($flag = NBR_CORE.DS.'installer'.DS.'firstrun.flag')) {
				$Router->redirect(str_replace(NBR_DOMAIN_ROOT, '', pathinfo($flag, PATHINFO_DIRNAME).DS.'index.php'));
			}
			# Load our hand print_r substitute
			$nApp->autoload('printpre');
			# Start the session
			$Session->start();
			# Convert all request forms to data node(s)
			$nGlobal->listen();
			# Fetch the server mode
			$server_mode	=	$Settings->getOption('devmode', 'system');
			# Get the server mode
			if(!empty($server_mode['devmode']['option_attribute']))
				$server_mode	=	$server_mode['devmode']['option_attribute'];
			# If not on, assume test
			if($server_mode != 'live') {
				ini_set('display_errors', 1);
				error_reporting(E_ALL);
			}
			else
				# Hide errors
				ini_set('display_errors', 0);
			# Start our program
			$AutomatorController->createWorkflow('default');
		});
    }
	# Get the normal buffer
	$data	=	ob_get_contents();
	# Stop the normal buffer
	ob_end_clean();
	# Write the normal buffer
	echo $data;
}
# Use this track if a core file is missing and is past the point of auto-generating
catch(HttpException\Core $e) {
    # Stop the normal buffer (don't output)
	ob_end_clean();
    $msg[]  =   rtrim($e->getMessage(), '.').'.<br />';
    $msg[]  =   (is_file(NBR_CLIENT_DIR.DS.'settings'.DS.'registry.xml'))? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Registry is created.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Registry missing';
    $msg[]  =   (is_file(NBR_CLIENT_DIR.DS.'settings'.DS.'dbcreds.php'))? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Database credentials are set.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Database credentials are not set.';
    $msg[]  =   '<br /><div style="padding: 1.5em; border: 1px solid #CCC; background-color: #F3F3F3;"><i class="fas fa-exclamation-triangle" style="color: orange;"></i>&nbsp;Core elements need to be installed by the system or manually created in order to resolve.</div>';
    echo str_replace('/domain/core/','/core/',sprintf(file_get_contents(NBR_CORE.DS.'settings'.DS.'startup'.DS.'index.txt'), 'Error '.$e->getCode()." - Startup Items Missing", implode('<br />', $msg)));
    exit;
}
catch(HttpException $e) {
	# Stop the normal buffer (don't output)
	ob_end_clean();
    # Create custom error page
    if(is_file($index = NBR_CLIENT_DIR.DS.'errors.php')) {
		include($index);
		die();
	}
	# Start our automator
	$Automator	=	$Application->getHelper('nAutomator\Observer');
	# Get our data obj
	$Node		=	$Application->getHelper('DataNode');
	# Save the message to data node
	$Node->addNode('_MESSAGES',[
		'msg'=>$e->getMessage(),
		'code'=>$e->getCode()
	]);
	# Set the default layout workflow to create
	switch($e->getCode()) {
		case(101):
			$layout	=	'offline';
			break;
		case(102):
			$layout	=	'maintenance';
			break;
		case(103):
			$layout	=	'installer';
			break;
		default:
			$layout	=	'error';
	}
    
	# Start our program
	$Automator
		->setWorkflow($layout)
		# Listen for the "action" key
		->setActionKey((defined('NBR_ACTION_KEY')? NBR_ACTION_KEY : 'action'))
		# Run the automator
		->listen();
}