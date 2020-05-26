<?php
$nRender	=	$data[1];
$defMsg		=	'A undefined error occurred.';
?><!doctype html>
<html>
<?php echo $nRender->getFrontEnd('head.php') ?>
<body>
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset">
	<div class="col-2">
		<h1>Error<?php echo (!empty($this->getDataNode('_MESSAGES')['code']))? ": #".$this->getDataNode('_MESSAGES')['code'] : '' ?></h1>
		<?php echo (!empty($this->getDataNode('_MESSAGES')['msg']))? $this->getDataNode('_MESSAGES')['msg'] : $defMsg ?>
	</div>
</div>
<?php echo $nRender->getFooter() ?>
</body>
</html>