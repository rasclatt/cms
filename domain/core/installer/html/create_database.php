<?php
if(empty($this))
    throw new \Exception("Forbidden", 403);

$data	=	[
	[
		'label' => 'Database Host',
		'name' => 'DB_HOST',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => (defined('DB_HOST'))? base64_decode(DB_HOST) : 'localhost'
	],
	[
		'label' => 'Database Name',
		'name' => 'DB_NAME',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => (defined('DB_NAME'))? base64_decode(DB_NAME) : ''
	],
	[
		'label' => 'Database Username',
		'name' => 'DB_USER',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => (defined('DB_USER'))? base64_decode(DB_USER) : 'root'
	],
	[
		'label' => 'Database Password',
		'name' => 'DB_PASS',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => (defined('DB_PASS'))? base64_decode(DB_PASS) : ''
	],
	[
		'label' => 'Database Character Set',
		'name' => 'DB_CHARSET',
		'other' => [
			'required="required"',
			'size="60"'
		],
		'class' => 'nbr',
		'value' => (defined('DB_CHARSET'))? DB_CHARSET : 'utf8'
	]
];

$err	=	$this->getDataNode('installer_error');
if(!empty($err)): ?>

<div style="background-color: red; padding: 0.5em 1em; color: #FFF; font-size: 1.2em; border-left: 5px solid #8A3232;"><?php echo $err ?></div>

<?php endif ?>

<div style="max-width: 600px;">
    <h1>Create your database connection.</h1>
    <p>You must first create an empty database and then fill out the form below with the connection information.</p>
    <?php echo $Form->open() ?>
        <?php echo $Form->fullhide(['name'=>'action', 'value' => 'save_dbcreds']) ?>
    <table border="0">
        <?php foreach($data as $field): ?>
        <tr>
            <td><?php echo $Form->text($field) ?></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td class="align-right"><?php echo $Form->submit(['value' => 'Save', 'class' => 'submit-form button']) ?></td>
        </td>
    </table>
    <?php echo $Form->close() ?>

<script>
    $(function(){
        $('form').on('click', '.submit-form', function(e) {
            e.preventDefault();
            
            var validate    =   [];
            var data    =   $(this).serializeArray();
            $.each(data, function(k,v){
                if(v.value != '') {
                    validate.push(1);
                }
            });
            
            if(validate.length == data.length) {
                $('form').submit();
            }
        });
    });
</script>
</div>