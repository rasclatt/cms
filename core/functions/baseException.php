<?php 
use \Nubersoft\ {
    nApp,
    nReflect
};

function baseException(nApp $Application, $e)
{
    # Create custom error page
    if (is_file($index = NBR_CLIENT_DIR . DS . 'errors.php') && !$Application->isAdmin()) {
        include($index);
    } else {
        # Start our automator
        $Automator = nReflect::instantiate('\Nubersoft\nAutomator\Observer');
        # Get our data obj
        $Node     = nReflect::instantiate('\Nubersoft\DataNode');
        # Save the message to data node
        $Node->addNode('_MESSAGES', [
            'msg' => $e->getMessage(),
            'code' => $e->getCode()
        ]);
        # Set the default layout workflow to create
        switch ($e->getCode()) {
            case (101):
                $layout = 'offline';
                break;
            case (102):
                $layout = 'maintenance';
                break;
            case (103):
                $layout = 'installer';
                break;
            default:
                $layout = 'error';
        }
        # Start our program
        $Automator
            ->setWorkflow($layout)
            # Listen for the "action" key
            ->setActionKey((defined('NBR_ACTION_KEY') ? NBR_ACTION_KEY : 'action'))
            # Run the automator
            ->listen();
    }
}