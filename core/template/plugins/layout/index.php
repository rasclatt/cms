<?php
use \Nubersoft\Settings\Page\View;
use \Nubersoft\Dto\Settings\Page\View\ConstructRequest as Request;
echo (new View(new Request()))->create($this->getPage('unique_id'), 'layout');