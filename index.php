<?php
include_once(__DIR__.DIRECTORY_SEPARATOR.'config.php');
# Default layout
$deftxt =   NBR_ROOT_DIR.DS.'core'.DS.'settings'.DS.'startup'.DS.'index.txt';
# Stop if support items not set
if(!class_exists('Nubersoft\nApp')) {
    die(sprintf(file_get_contents($deftxt), 'Gettings Started', 'You will need to run <a href="http://www.getcomposer.org/" target="_blank" class="pointer">Composer</a> to fetch the required classes or <a href="https://github.com/rasclatt/nubersoft" target="_blank" class="pointer">manually install</a> the supporting classes.'));
}
$flag = NBR_DOMAIN_ROOT.DS.'core'.DS.'installer'.DS.'firstrun.flag';
if(\Nubersoft\nApp::call()->getGet('resetflag')) {
    file_put_contents($flag, PHP_EOL);
}
# Start setup
if(is_file($flag)) {
    $redirect   =   str_replace($_SERVER["DOCUMENT_ROOT"], '', NBR_DOMAIN_ROOT.DS.'core'.DS.'installer/');
    \Nubersoft\nApp::call()->redirect($redirect);
}
else {
    echo sprintf(file_get_contents($deftxt), 'Complete Set-up', 'To finish set-up, change your hosting to point your root directory to the <code class="shaded">domain</code> folder. If this is the first run and you have not gone through the set-up, you can <a href="?resetflag=true">click here</a> to start.');
}