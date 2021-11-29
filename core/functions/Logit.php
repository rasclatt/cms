<?php
# Save basic logging of errors
function Logit($e)
{
    LogItAll($e->getMessage());
}