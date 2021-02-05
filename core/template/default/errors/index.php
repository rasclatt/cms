<?php
$nRender	=	$data[1];
$defMsg		=	'A undefined error occurred.';
$code   =   ($this->getDataNode('_MESSAGES')['code'])?? 10001;
$filter =   [
    10000 => 'Site is unavailable at this time',
    10001 => $defMsg,
    10002 => 'Site is down for maintenance'
];
?><!doctype html>
<html>
<?php echo $nRender->getFrontEnd('head.php') ?>
<body id="error-page error-<?php echo $code ?>">
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset">
	<div class="start2 align-middle pad-top-3 pad-bottom-3">   
        <div class="alert alert-success" role="alert">
            <?php if($code == 10002): ?>
            <div class="pad-1 align-middle">
                <i class="fas fa-cogs fa-4x"></i>
            </div>
            <?php endif ?>
            <h4 class="alert-heading"><?php if(!isset($filter[$code])) echo "Error: #".$code ?></h4>
            <p><?php echo ($filter[$code])?? $this->getDataNode('_MESSAGES')['msg'] ?></p>
        </div>
	</div>
</div>
<?php echo $nRender->getFooter() ?>
</body>
</html>