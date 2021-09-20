<?php 
function finalException()
{
    die(include(((is_file($index = NBR_CLIENT_DIR))? $index : NBR_CORE.DS.'html') . DS . 'errors.php'));
}