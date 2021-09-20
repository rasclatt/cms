<?php
function coreException(Exception $e): string
{
    $msg[] = rtrim($e->getMessage(), '.') . '.<br />';
    $msg[] = (is_file(NBR_CLIENT_DIR . DS . 'settings' . DS . 'registry.xml')) ? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Registry is created.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Registry missing';
    $msg[] = (is_file(NBR_CLIENT_DIR . DS . 'settings' . DS . 'dbcreds.php')) ? '<i class="fas fa-clipboard-check" style="color: green;"></i>&nbsp;Database credentials are set.' : '<i class="fas fa-skull-crossbones" style="color: red;"></i>&nbsp;Database credentials are not set.';
    $msg[] = '<br /><div style="padding: 1.5em; border: 1px solid #CCC; background-color: #F3F3F3;"><i class="fas fa-exclamation-triangle" style="color: orange;"></i>&nbsp;Core elements need to be installed by the system or manually created in order to resolve.</div>';
    return str_replace('/domain/core/', '/core/', sprintf(file_get_contents(NBR_CORE . DS . 'settings' . DS . 'startup' . DS . 'index.txt'), 'Error ' . $e->getCode() . " - Startup Items Missing", implode('<br />', $msg)));
}