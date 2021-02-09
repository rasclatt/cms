<?php
namespace Nubersoft;

use \Nubersoft\ {
    nGlobal\Observer as nGlobal,
    nAutomator\Controller as nAutomator
};
#check if cron job set
if(!empty($argv[1])) {
	# Set the request manually
	$_REQUEST	=	[];
	parse_str($argv[1], $_REQUEST);
}
/**
 *	@description	Loader assist functions
 */
if(!function_exists('Logit')) {
    # Save basic logging of errors
    function Logit($e)
    {
        LogItAll($e->getMessage());
    }
    # Save the actual file
    function LogItAll($str)
    {
        @file_put_contents(NBR_CLIENT_DIR.DS.date('Y-m-d_').'errors.txt', "[".date('H:i:s')."] ".$str.PHP_EOL, FILE_APPEND);
    }
    # Back out the buffer to original layer for error page
    function cleanBuffer()
    {
        while (ob_get_level() > 1) {
            ob_end_clean();
        }
    }
}
# Add our application config
require_once(realpath(__DIR__.DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR.'config.php');

try {
    # Add an external index page to overwrite this page
    if(is_file($inc = NBR_CLIENT_DIR.DS.'index.php')) {
        include($inc);
        exit;
    }
    # Create instance of the main class
    $Application	=	nApp::call();
    # Start buffering
    ob_start();
    try {
        # Create a container application
        $Application->createContainer(function(
            nApp $nApp,
            nSession $Session,
            nGlobal $nGlobal,
            nAutomator $AutomatorController,
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
            # Start saving warnings to the system
            set_error_handler(function($code, $msg) {
                \Nubersoft\nApp::call()->toError("Error {$code}: {$msg}");
            }, E_WARNING);
            # If not on, assume test
            if($server_mode != 'live') {
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
            }
            else {
                # Hide errors
                ini_set('display_errors', 0);
            }
            # Run jwt checks if there is a checker
            if(class_exists('\Nubersoft\JWT\Controller')) {
                # Fetch token secret
                $jwt = JWT\Controller::getJwtTokenSecret();
                # If there is a secret
                if($jwt) {
                    if(!empty($nApp->getPost())) {
                        try {
                            # Validate the token
                            JWTFactory::get()->get($nApp->dec($nApp->getPost('jwtToken')));
                        }
                        catch (\Exception $e) {
                            //throw new Exception\Ajax($nApp->getPost('jwtToken'), 403);
                            # Report back with ajax or same-page
                            if($nApp->isAjaxRequest())
                                throw new Exception\Ajax('Invalid security token', 403);
                            # Throw normal exception
                            throw new \Exception('Invalid security token', 403);
                        }
                    }
                }
            }
            # Start our program
            $AutomatorController->createWorkflow('default');
        });
    }
    # Use this track if a core file is missing and is past the point of auto-generating
    catch(HttpException\Core $e) {
        cleanBuffer();
        Logit($e);
        $msg[]  =   rtrim($e->getMessage(), '.').'.<br />';
        $msg[]  =   (is_file(NBR_CLIENT_DIR.DS.'settings'.DS.'registry.xml'))? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Registry is created.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Registry missing';
        $msg[]  =   (is_file(NBR_CLIENT_DIR.DS.'settings'.DS.'dbcreds.php'))? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Database credentials are set.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Database credentials are not set.';
        $msg[]  =   '<br /><div style="padding: 1.5em; border: 1px solid #CCC; background-color: #F3F3F3;"><i class="fas fa-exclamation-triangle" style="color: orange;"></i>&nbsp;Core elements need to be installed by the system or manually created in order to resolve.</div>';
        echo str_replace('/domain/core/','/core/',sprintf(file_get_contents(NBR_CORE.DS.'settings'.DS.'startup'.DS.'index.txt'), 'Error '.$e->getCode()." - Startup Items Missing", implode('<br />', $msg)));
    }
    catch(Exception\Ajax $e) {
        cleanBuffer();
        Logit($e);
        $e->ajaxResponse();
    }
    catch(HttpException | \PDOException | \Exception $e) {
        cleanBuffer();
        Logit($e);
        # Create custom error page
        if(is_file($index = NBR_CLIENT_DIR.DS.'errors.php') && !$Application->isAdmin()) {
            include($index);                                                    
        }
        else {
            # Start our automator
            $Automator	=	nReflect::instantiate('\Nubersoft\nAutomator\Observer');
            # Get our data obj
            $Node		=	nReflect::instantiate('\Nubersoft\DataNode');
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
    }
    # Get the normal buffer
    $data	=	ob_get_contents();
    # Stop the normal buffer
    @ob_end_clean();
    # Write the normal buffer
    echo $data;
}
catch (\Exception $e) {
    if(is_file($index = NBR_CLIENT_DIR.DS.'errors.php')):
        include($index);
    else: ?>

<html>
    <style>
        * {box-sizing: border-box; font-family: Arial; text-align: center;}
        body,html {padding: 0; margin: 0; height: 100vh; width: 100vw; background-color: #222; color: #FFF;}
        body {display: flex; flex-direction: column; justify-content: center; align-content: center; align-items: center; }
        
    </style>
    <body>
        <div>
            <h2>Whoops!</h2>
            <p><?php echo $e->getMessage() ?></p>
        </div>
    </body>
</html>

    <?php 
    endif;
}
