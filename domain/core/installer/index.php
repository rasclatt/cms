<?php
namespace Nubersoft;
error_reporting(E_ALL);
ini_set('display_errors', 1);
# Do minimum check
if(!function_exists('simplexml_load_string')) {
    die('The SimpleXml functions are required. Make sure to install php xml and add "extension=simplexml.so" to your php.ini file.');
}
# Separator
$DS	=	DIRECTORY_SEPARATOR;
# Add our application config
require_once(realpath(__DIR__.$DS.'..'.$DS.'..'.$DS.'..').$DS.'config.php');
# If installer is set but not yet initialized go back
if(!class_exists('Nubersoft\nApp')) {
    header('Location: ../../../index.php');
    exit;
}
# Create instance of the main class
$Application	=	nApp::call();
# Start application
try {
	# Start buffering
	ob_start();
	# Create a container application
	$Application->createContainer(function(
		nApp $nApp,
		nSession $Session,
		nGlobal\Observer $nGlobal,
		nAutomator\Controller $AutomatorController
	){
		# Load our hand print_r substitute
		$nApp->autoload('printpre');
		# Start the session
		$Session->start();
		# Convert all request forms to data node(s)
		$nGlobal->listen();
		# Start our program
		$AutomatorController->createWorkflow('installer');
	});
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