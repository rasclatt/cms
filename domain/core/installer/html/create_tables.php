<?php
if(empty($this))
    throw new \Exception("Forbidden", 403);

$fetch	=	$this->getDataNode('data');

$data	=	[
	[
		'label' => 'Admin Email (username)',
		'name' => 'username',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => $this->getPost('username')
	],
	[
		'type' => 'password',
		'label' => 'Admin Password',
		'name' => 'password',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => $this->getPost('password')
	]
];

$err	=	$this->getDataNode('table_error');
if(!empty($err)): ?>
<div class="nbr_error"><?php echo $err ?></div>
<?php endif ?>
<h1>Create Database Tables and Admin User.</h1>
<?php echo $Form->open() ?>
	<?php echo $Form->fullhide(['name'=>'action', 'value' => 'create_admin_user']) ?>
<table border="0">
	<?php foreach($data as $field): ?>
	<tr>
		<td><?php echo (!empty($field['type']))? $Form->{$field['type']}($field) : $Form->text($field) ?></td>
	</tr>
	<?php endforeach ?>
	<tr>
		<td class="align-right"><?php echo $Form->submit(['value' => 'Save', 'class' => 'button']) ?></td>
	</td>
</table>
<?php echo $Form->close();

if(empty($fetch['data']['tables'])) {

	include(__DIR__.DS.'..'.DS.'database.php');

	foreach($create as $sql) {
		try {
			$this->getHelper("nQuery")->query($sql);
		}
		catch (\PDOException $e) {
			echo 'Error: '.$e->getMessage().'<br />';
		}
	}

	foreach($insert as $sql)
		$this->getHelper("nQuery")->query($sql);
}