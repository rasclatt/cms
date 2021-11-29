<?php
# Back out the buffer to original layer for error page
function cleanBuffer()
{
    while (ob_get_level() > 1) {
        ob_end_clean();
    }
}