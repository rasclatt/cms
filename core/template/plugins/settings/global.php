<?php
use \Nubersoft\ {
    nForm as Form
};

$defaultVars	=	extract([
	'sign_up' => [],
	'maintenance_mode' => [],
	'frontend_admin' => [],
	'site_live' => [],
	'template' => [],
	'timezone' => [],
	'htaccess' => [],
	'two_factor_auth' => [],
	'webmaster' => [],
	'fileid' => [],
	'devmode' => [],
	'jwt_token' => []
]);

$system_settings	=	\Nubersoft\ArrayWorks::organizeByKey($this->getDataNode('settings')['system'],'category_id');
$Settings			=	extract($system_settings);

$Setting    =   $this->getHelper('Settings');
$composer   =   $Setting->getSystemOption('composer');
$cfile  =   file_get_contents(NBR_ROOT_DIR.DS.'composer.json');

if(empty($composer)) {
    if($cfile) {
        $Setting->setOption('composer', $cfile, 'system');
        $composer   =   $Setting->getSystemOption('composer');
    }
}
$defaults			=	[
    [
        'description' => '<h3>Composer Settings</h3>
        <p>These are your Composer live and database-stored settings.</p>',
		'label' => 'Composer (Live)',
		"name" => "",
		"type" => "textarea",
		'value' => file_get_contents(NBR_ROOT_DIR.DS.'composer.json'),
		'class' => 'nbr textarea tabber code',
        'style' => 'height: 500px;',
        'other' => ['readonly']
	],
    [
		'label' => 'Composer (Stored)',
		"name" => "setting[composer]",
		"type" => "textarea",
		'value' => json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
		'class' => 'nbr textarea tabber code',
        'style' => 'height: 500px;'
	],
	[ 
        'description' => '<h3>Website Settings</h3>
        <p>These are general settings for the site</p>',
		'label' => 'Webmaster'.((defined('WEBMASTER'))? ' (Registry: '.WEBMASTER.')':''),
		"name" => "setting[webmaster]",
		"type" => "text",
		'value' => (!empty($webmaster['option_attribute']))? $webmaster['option_attribute'] : (defined('WEBMASTER')? WEBMASTER : ""),
		'class' => 'nbr',
		'other' => [
			'required="required"'
		]
	],
	[
		'label' => 'Allow Public Sign Up?',
		"name" => "setting[sign_up]",
		"type" => "select",
		"options" => array_map(function($v) use ($sign_up) {
			if(isset($sign_up['option_attribute']) && $v['value'] == $sign_up['option_attribute'])
				$v['selected']	=	true;
			
			return $v;
		}, [
			["name" => "No","value" => "off"],
			["name" => "Yes","value" => "on"]
		]),
		'class' => 'nbr'
	],
	[
		'label' => '2 Factor Authentiation',
		"name" => "setting[two_factor_auth]",
		"type" => "select",
		"options" => array_map(function($v) use ($two_factor_auth) {
			if(!empty($two_factor_auth) && ($v['value'] == $two_factor_auth['option_attribute']))
				$v['selected']	=	true;
			
			return $v;
		}, [
			["name" => "Disabled (Use Basic Login)", 'value' => 'off'],
			["name" => "Admin Only","value" => "admin"],
			["name" => "Frontend Only","value" => "frontend"],
			["name" => "Admin and Frontend","value" => "both"]
		]),
		'class' => 'nbr'
	],
	[
		'label' => 'Allow Frontend Admin Login?',
		'name' => 'setting[frontend_admin]',
		'type' => 'select',
		"options" => array_map(function($v) use ($frontend_admin) {
			if(!empty($frontend_admin['option_attribute']) && ($v['value'] == $frontend_admin['option_attribute']))
				$v['selected']	=	true;
			
			return $v;
		},[
			["name" => "No","value" => "off"],
			["name" => "Yes","value" => "on"]
		]),
		'class' => 'nbr'
	],
	[
        'description' => '<h3>Website Activation Modes</h3>
        <p>These effect how your website is displayed to the public.</p>',
		'label' => 'Maintenance Mode',
		'name' => 'setting[maintenance_mode]',
		'type' => 'select',
		"options" => array_map(function($v) use ($maintenance_mode) {
			if(!empty($maintenance_mode['option_attribute']) && ($v['value'] == $maintenance_mode['option_attribute']))
				$v['selected']	=	true;
			
			return $v;
		},[
			["name" => "Off","value" => "off"],
			["name" => "On","value" => "on"]
		]),
		'class' => 'nbr'
	],
	[
		'label' => 'Site Status',
		'name' => 'setting[site_live]',
		'type' => 'select',
		"options" => array_map(function($v) use ($site_live) {
			if(isset($site_live['option_attribute']) && ($v['value'] == $site_live['option_attribute']))
				$v['selected']	=	true;
			
			return $v;
		},[
			["name" => "Inactive","value" => "off"],
			["name" => "Live","value" => "on"]
		]),
		'class' => 'nbr'
	],
	[
		'label' => 'Global Template',
		'name' => 'setting[template]',
		'type' => 'select',
		'options' =>
			$this->createContainer(function(\Nubersoft\Settings\Page\Controller $Page) use ($system_settings){
				$val	=	(!empty($system_settings['template']['option_attribute']))? $system_settings['template']['option_attribute'] : false;
				
				return array_map(function($v) use ($val) {
					if($v['value'] == $val)
						$v['selected']	=	true;
					
					return $v;
				},$Page->getTemplateList());
			}),
		'class' => 'nbr'
	],
	[
        'description' => '<h3>Server Settings</h3>
        <p>Set some server preferences.</p>',
		'label' => 'Site Timezone ('.date('Y-m-d H:i:s').')',
		'name' => 'setting[timezone]',
		'type' => 'select',
		'options' => array_map(function($v) use ($timezone) {
			return [
				'name' => str_replace(['/', '_'],[' – ', ' '],$v),
				'value' => $v,
				'selected' => (isset($timezone['option_attribute']) && ($timezone['option_attribute'] == $v))
			];
		},\DateTimeZone::listIdentifiers()),
		'class' => 'nbr'
	],
	[
		'label' => 'Server Rewriting',
		'name' => 'setting[htaccess]',
		'type' => 'textarea',
		'value' => (!empty($htaccess['option_attribute']))? $htaccess['option_attribute'] : $this->enc(file_get_contents(NBR_DOMAIN_ROOT.DS.'.htaccess')),
		'class' => 'nbr tabber code required',
		'other' => ['required="required"'],
		'style' => 'height: 300px;'
	],
	[
        'description' => '<h3>Development / Production Settings</h3>
        <p>Help develop the site using server-side warnings in dev mode. Toggle to production when you want to silence server-side errors.</p>',
		'label' => 'Show File Inclusions',
		'name' => 'setting[fileid]',
		'type' => 'select',
		'options' => array_map(function($v) use ($fileid) {
			if(!empty($fileid['option_attribute']) && $fileid['option_attribute'] == $v['value'])
				$v['selected']	=	true;
				
			return $v;
		}, [
			[
				'name' => 'Off',
				'value' => 'off'
			],
			[
				'name' => 'On',
				'value' => 'on'
			]
		]),
		'class' => 'nbr required',
		'other' => ['required="required"']
	],
	[
		'label' => 'Production Mode',
		'name' => 'setting[devmode]',
		'type' => 'select',
		'options' => array_map(function($v) use ($devmode) {
			if(!empty($devmode['option_attribute']) && $devmode['option_attribute'] == $v['value'])
				$v['selected']	=	true;
				
			return $v;
		}, [
			[
				'name' => 'Production Mode',
				'value' => 'live'
			],
			[
				'name' => 'Developer Mode',
				'value' => 'dev'
			]
		]),
		'class' => 'nbr required',
		'other' => ['required="required"']
	]
];
?>
<?php echo $this->getPlugin('admintools', 'admin_ui.php') ?>
<h2>Global Settings</h2>
<p>These settings adjust various website settings that effect the site's behaviour.</p>
<div class="section-head nTrigger margin-top-0 arrow-down white" data-instructions='{"FX":{"fx":["slideUp","accordian"],"event":["click","click"],"acton":[".section","next::slideToggle"],"fxspeed":["fast","fast"]}}'>General Settings</div>
<div class="section hide section-general">
    
	<?php
	$Form	=	@$this->nForm();
	echo $Form->open(["action" => "?loadpage=load_settings_page&subaction=global"]);
	echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
	echo $Form->fullhide(['name' => 'action', 'value' => 'save_settings']);
	echo $Form->fullhide(['name' => 'category_id', 'value' => 'site']);
	echo $Form->fullhide(['name' => 'option_group_name', 'value' => 'system']);
	?>

		<?php
		foreach($defaults as $row):
			$type	=	$row['type'];
			unset($row['type']);
    
            if(isset($row['description'])) {
                echo $row['description'];
                unset($row['description']);
            }
		?>

        <?php echo $Form->{$type}($row) ?>
		
		<?php endforeach ?>

        <?php echo $Form->submit(['value' => 'Save', 'class' => 'medi-btn dark settings']) ?>
			
	<?php echo $Form->close() ?>
</div>

<div class="section-head nTrigger arrow-down white" data-instructions='{"FX":{"fx":["slideUp","accordian"],"event":["click","click"],"acton":[".section","next::slideToggle"],"fxspeed":["fast","fast"]}}'>Admin Setup</div>
<div class="section hide">
	<h3>Backend Name</h3>
	<p>Change your back office path name to help keep it masked from unwanted probing.</p>
	<?php
	$ap = $this->nRouter()->getPage(1, 'is_admin');
	if($ap instanceof \SmartDto\Dto)
		$ap = $ap->toArray();
	extract(@$ap);
	echo $Form->open(['enctype' => 'multipart/form-data', "action" => "?loadpage=load_settings_page&subaction=global"]);
	echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
	echo $Form->fullhide(['name' => 'action', 'value' => 'update_admin_url']);
	echo $Form->fullhide(['name' => 'ID', 'value' => ($ID)?? null]);
	?>

		<div class="col-count-4 lrg-2 med-1">
			<div class="">
				<?php echo $Form->text(['label' => 'Admin Title', 'name' => 'menu_name', 'value' => ($menu_name)?? null, 'class' => 'nbr', 'other' => ['required="required"']]) ?>
			</div>
			<div class="start1">
				<?php echo $Form->text(['label' => 'Slug / Url', 'name' => 'full_path', 'value' => ($full_path)?? null, 'class' => 'nbr', 'other' => ['required="required"']]) ?>
			</div>
			<div class="start1">
				<?php echo $Form->select([
				'label' => 'Template',
				'name' => 'template',
				'type' => 'select',
				'options' =>
					$this->createContainer(function(\Nubersoft\Settings\Page\Controller $Page) use ($template) {
						
						return array_map(function($v) use ($template) {
							if($v['value'] == $template)
								$v['selected']	=	true;

							return $v;
						},$Page->getTemplateList());
					}),
				'class' => 'nbr'
			]) ?>
			</div>
			<div class="start1">
				<?php echo $Form->submit(['value' => 'Save', 'class' => 'medi-btn dark settings']) ?>
			</div>
		</div>

	<?php echo $Form->close() ?>
</div>

<div class="section-head nTrigger arrow-down white" data-instructions='{"FX":{"fx":["slideUp","accordian"],"event":["click","click"],"acton":[".section","next::slideToggle"],"fxspeed":["fast","fast"]}}'>Site Logo</div>
<div class="section hide show">
    <h3>Corporate Logo</h3>
	<p>Update your web site logo (jpeg, jpg, gif, png). This logo will be available in the front end as well as the back end, depending on your template.</p>
	<?php
	echo $Form->open(['enctype' => 'multipart/form-data', "action" => "?loadpage=load_settings_page&subaction=global"]);
	echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
	echo $Form->fullhide(['name' => 'action', 'value' => 'save_settings_sitelogo']);
	echo $Form->fullhide(['name' => 'category_id', 'value' => 'site']);
	echo $Form->fullhide(['name' => 'option_group_name', 'value' => 'system']);
	?>
		<div class="col-count-3 col-c1-lg">
			<div class="start1">
				<?php
				$header_company_logo_toggle	=	(isset($header_company_logo_toggle))? $header_company_logo_toggle : false;
				echo $Form->select([
					'label' => 'Site Logo On?',
					'name' => 'setting[header_company_logo_toggle]',
					'type' => 'select',
					'options' => array_map(function($v) use ($header_company_logo_toggle) {
						return [
							'name' => $v['name'],
							'value' => $v['value'],
							'selected' => (!empty($header_company_logo_toggle['option_attribute']) && $header_company_logo_toggle['option_attribute'] == $v['value'])
						];
					},[
						["name" => "Off","value" => "off"],
						["name" => "On","value" => "on"]
					]),
					'class' => 'nbr'
				]) ?>
			</div>
		</div>
		<div class="col-count-3 col-c1-lg">
			<?php if(!empty($header_company_logo['option_attribute']) && is_file(NBR_DOMAIN_ROOT.DS.ltrim(str_replace('/',DS,$header_company_logo['option_attribute']), DS))): ?>
			<div class="start1" style="background-image: url('/core/template/default/media/images/ui/transparent-grid.gif'); background-repeat: repeat; background-size: 8px; padding: 2em; margin-top: 1em;">
				<img src="<?php echo $header_company_logo['option_attribute'] ?>" />
			</div>
			<div class="span-3 push-col-1 large">
				<p>
				File Size: <?php echo @$this->Conversion_Data()->getByteSize(filesize(NBR_DOMAIN_ROOT.DS.$header_company_logo['option_attribute']),[
					'from' => 'b',
					'to' => 'kb',
					'round' => 2
	]) ?>KB</p>
			</div>
			<?php endif ?>
			<div class="start1">
				<?php echo $Form->file(['name' => 'file', 'class' => 'nbr']) ?>
			</div>
		</div>
		<div class="col-count-4 lrg-2 med-1">
			<div class="start1">
				<?php echo $Form->submit(['value' => 'Save', 'class' => 'medi-btn dark settings']) ?>
			</div>
		</div>

	<?php echo $Form->close() ?>
</div>

<div class="section-head nTrigger arrow-down white" data-instructions='{"FX":{"fx":["slideUp","accordian"],"event":["click","click"],"acton":[".section","next::slideToggle"],"fxspeed":["fast","fast"]}}'>Security</div>
<div class="section hide show">
    <h3>JWT Settings</h3>
    
    <p class="margin-top-1">JWT Tokens are generated on each load of the page but because they do not persist, they can not be matched from page load to page submit. Create a static token for matching page-to-page tokens.</p>
    
    <?php $jwt  =   \Nubersoft\JWT\Controller::getJwtTokenSecret() ?>
    <?php echo Form::getOpen(['class' => 'ajax']) ?>
        <?php echo Form::getFullhide(['name' => 'action', 'value' => 'create_jwtoken']) ?>
        <div class="col-count-3 gapped col-c2-md col-c1-sm">
            <?php echo Form::getPassword(['label' => 'JWT Secret', 'name' => 'token_name', 'value' => $jwt, 'class' => 'nbr']) ?>
        </div>
            
        <div style="align-self: end;"><?php echo Form::getSubmit(['value' => 'SAVE', 'class' => 'medi-btn dark settings margin-bottom-0']) ?></div>
        
    <?php echo Form::getClose() ?>
    <script>
        $(function(){
            $('input[name="token_name"]').on('focus focusout', function(e){
                $(this).attr('type', (e.type == 'focus')? 'text' : 'password');
            });

           $('.ajax').on('submit', function(e) {
               e.preventDefault();
               AjaxEngine.ajax($(this).serialize(), (r) => {
                   default_action($(this), r);
               });
           });
        });
        // Calls the form token
        fetchAllTokens($);
    </script>
</div>

<?php echo $this->getPlugin('settings', 'global'.DS.'locale.php') ?>

<?php // echo printpre($this->query("select * from system_settings")->getResults()) ?>
