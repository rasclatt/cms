<?php
include(__DIR__.DIRECTORY_SEPARATOR.'config.php');
# Default layout
$deftxt =   NBR_ROOT_DIR.DS.'core'.DS.'settings'.DS.'startup'.DS.'index.txt';
# Stop if support items not set
if(!class_exists('Nubersoft\nApp')) {
    die(sprintf(file_get_contents($deftxt), 'Gettings Started', 'You will need to run <a href="http://www.getcomposer.org/" target="_blank" class="pointer">Composer</a> to fetch the required classes or <a href="https://github.com/rasclatt/nubersoft" target="_blank" class="pointer">manually install</a> the supporting classes.'));
}
# Start setup
if(is_file(NBR_DOMAIN_ROOT.DS.'core'.DS.'installer'.DS.'firstrun.flag')) {
    $redirect   =   str_replace($_SERVER["DOCUMENT_ROOT"], '', NBR_DOMAIN_ROOT.DS.'core'.DS.'installer/');
    \Nubersoft\nApp::call()->redirect($redirect);
}
else {
    echo sprintf(file_get_contents($deftxt), 'Complete Set-up', 'To finish set-up, change your hosting to point your root directory to the <code class="shaded">domain</code> folder.');
}