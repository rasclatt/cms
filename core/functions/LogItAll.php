<?php
# Save the actual file
function LogItAll($str)
{
    @file_put_contents(NBR_CLIENT_DIR . DS . date('Y-m-d_') . 'errors.txt', "[" . date('H:i:s') . "] " . $str . PHP_EOL, FILE_APPEND);
}