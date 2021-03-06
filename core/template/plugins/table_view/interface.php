<?php
$table	=	$this->getRequest('table');
if(empty($table))
	return false;

$fields	=	$this->getColumnsInTable($this->getRequest('table'));

$this->setNode('table_data', array_combine($fields, array_fill(0,count($fields),''))
);
?>
<div class="col-count-5 gapped col-c3-lg col-c1-sm pad-bottom-1 margin-bottom-1">
	<?php if(!empty($this->getRequest('create')) || !empty($this->getRequest('edit'))): ?>
	<div><a class="nbr button green small" href="?table=<?php echo $this->getRequest('table') ?>"><?php echo $this->colToTitle($this->getGet('table')) ?></a></div>
	<?php endif ?>
	<?php if(empty($this->getRequest('create'))): ?>
	<div><a class="nbr button green small" href="?table=<?php echo $this->getRequest('table') ?>&create=true">New Row</a></div>
	<?php endif ?>
</div>