<?php 
include(__DIR__.DIRECTORY_SEPARATOR.'config.php');

if(is_file(NBR_DOMAIN_ROOT.DS.'core'.DS.'installer'.DS.'firstrun.flag')):
    $redirect   =   str_replace($_SERVER["DOCUMENT_ROOT"], '', NBR_DOMAIN_ROOT.DS.'core'.DS.'installer/');
    \Nubersoft\nApp::call()->redirect($redirect);
else: ?>

To finish set-up, change your hosting to point your root directory to the "domain" folder.

<?php endif;