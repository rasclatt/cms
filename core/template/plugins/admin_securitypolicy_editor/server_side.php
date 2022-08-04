<?php 
use \NubersoftCms\ContentPolicyManager\Model as Manager;
$Manager = new Manager();
$meta = $Manager->get();
if(empty($meta->policies))
    return false;
if($this->getPage('is_admin') == 1)
    return false;
    
header('Content-Security-Policy: '.$this->dec($meta->content));