<?php
$Settings	=	extract(\Nubersoft\ArrayWorks::organizeByKey($this->getDataNode('settings')['system'],'category_id'));
if(empty($header_html))
	$header_html	=	[];
if(empty($header_html_toggle))
	$header_html_toggle	=	[];

$defaults	=	[
	[
		'label' => 'Use Mast Head HTML?',
		"name" => "setting[header_html_toggle]",
		"type" => "select",
		"options" => array_map(function($v) use ($header_html_toggle) {
			if(!empty($header_html_toggle) && ($v['value'] == $header_html_toggle['option_attribute']))
				$v['selected']	=	true;
			
			return $v;
		}, [
			["name" => "Off","value" => "off"],
			["name" => "On","value" => "on"]
		]),
		'class' => 'nbr'
	],
	[
		'name' => 'setting[header_html]',
		'type' => 'textarea',
		'value' => (!empty($header_html['option_attribute']))? $header_html['option_attribute'] : '',
		'class' => 'nbr tabber code',
		'style' => 'height: 300px;'
	],
	[
		'label' => 'Create Head Tag Javascript',
		'name' => 'setting[header_javascript]',
		'type' => 'textarea',
		'value' => (!empty($header_javascript['option_attribute']))? $header_javascript['option_attribute'] : '',
		'class' => 'nbr tabber code',
		'style' => 'height: 300px;'
	],
	[
		'label' => 'Create Head Tag Styles',
		'name' => 'setting[header_styles]',
		'type' => 'textarea',
		'value' => (!empty($header_styles['option_attribute']))? $header_styles['option_attribute'] : '',
		'class' => 'nbr tabber code',
		'style' => 'height: 300px;'
	],
	[
		'label' => 'Create Default Head Tag Meta',
		'name' => 'setting[header_meta]',
		'type' => 'textarea',
		'value' => (!empty($header_meta['option_attribute']))? $header_meta['option_attribute'] : '',
		'class' => 'nbr tabber code',
		'style' => 'height: 300px;'
	]
];
?>
<?php echo $this->getPlugin('admintools', 'admin_ui.php') ?>
<h3>Header Settings</h3>
<p>Change header settings for your site.</p>
<?php
$Form	=	@$this->nForm();
echo $Form->open(["action" => "?loadpage=load_settings_page&subaction=header"]);
echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
echo $Form->fullhide(['name' => 'action', 'value' => 'save_settings']);
echo $Form->fullhide(['name' => 'category_id', 'value' => 'site']);
echo $Form->fullhide(['name' => 'option_group_name', 'value' => 'system']);
?>

	<?php
	foreach($defaults as $row):
		$type	=	$row['type'];
		unset($row['type']);
	?>

    <?php echo $Form->{$type}($row) ?>
            
	<?php endforeach ?>
	
			<?php echo $Form->submit(['value' => 'Save', 'class' => 'medi-btn dark settings']) ?>
	
<?php echo $Form->close() ?>
<script>
	// Calls the form token
	fetchAllTokens($);
</script>