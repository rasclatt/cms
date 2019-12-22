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
# Execute view
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
catch(HttpException $e) {
	# Stop the normal buffer (don't output)
	ob_end_clean();
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