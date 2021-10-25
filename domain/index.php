<?php
namespace Nubersoft;
# Set dto helpers
use \NubersoftCms\Dto\Index\ {
    CreateContainerRequest as StartUpApps,
    GetServerSettings as Settings,
    PostRequest
};
# Report all error up to the application init
ini_set('display_errors', 1);
error_reporting(E_ALL);
#check if cron job set
if (!empty($argv[1])) {
    # Set the request manually
    $_REQUEST = [];
    parse_str($argv[1], $_REQUEST);
}
# Add our application config
require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'config.php');
# Add start up assist functions. Allows for client overrides
foreach (scandir(NBR_CORE_FUNCTIONS) as $finc) {
    $f = NBR_CLIENT_FUNCTIONS . DS . $finc;
    if (!is_file($f)) {
        $f = NBR_CORE_FUNCTIONS . DS . $finc;
        if (!is_file($f))
            continue;
    }
    # Only include one time so
    include_once($f);
}
try {
    # Add an external index page to overwrite this page
    if (is_file($inc = NBR_CLIENT_DIR . DS . 'index.php')) {
        include($inc);
        exit;
    }
    # Create instance of the main class
    $Application = nApp::call();
    # Start buffering
    ob_start();
    try {
        # Create a container application
        $Application->createContainer(function(StartUpApps $StarUp) {
            # Set the base post
            $post = new PostRequest($StarUp->nApp->getPost());
            # Checks to see if the is the first time running
            $StarUp->initStartUp();
            # Load our hand print_r substitute
            $StarUp->nApp->autoload('printpre');
            # Start the session
            $StarUp->Session->start();
            # Convert all request forms to data node(s)
            $StarUp->nGlobal->listen();
            # Fetch the server mode
            $server = new Settings($StarUp->Settings->getOption('devmode', 'system'));
            # Start saving warnings to the system
            set_error_handler(function ($code, $msg) use ($StarUp) {
                $StarUp->nApp->toError("Error {$code}: {$msg}");
            }, E_WARNING);
            # If not on, assume test
            $server->reportMode();
            # Allow translation to get through
            if ($post->service != 'translation') {
                # Check if action is run
                if (!empty($post->action))
                    jwtChecker($StarUp->nApp);
            }
            # Start our program
            $StarUp->runApplication();
        });
    }
    # Use this track if a core file is missing and is past the point of auto-generating
    catch (HttpException\Core $e) {
        cleanBuffer();
        Logit($e);
        die(coreException($e));
    } catch (Exception\Ajax $e) {
        cleanBuffer();
        Logit($e);
        $e->ajaxResponse();
    } catch (HttpException | \PDOException | \Exception $e) {
        cleanBuffer();
        Logit($e);
        baseException($e, $Application);
    }
    # Get the normal buffer
    $data = ob_get_contents();
    # Stop the normal buffer
    @ob_end_clean();
    # Write the normal buffer
    echo $data;
} catch (\Exception $e) {
    finalException();
}