<?php 
use \NubersoftCms\ContentPolicyManager\Model as Manager;
$Manager = new Manager();
$meta = $Manager->get();
if(empty($meta->policies))
    return false;
if($this->getPage('is_admin') == 1)
    return false;
?><meta http-equiv="Content-Security-Policy<?php if(!$meta->active) echo '-Read-Only' ?>" content="<?php echo $this->dec($meta->content) ?>" />
