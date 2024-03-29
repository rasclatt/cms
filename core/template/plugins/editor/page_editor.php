<?php
if ($this->getSession('editor') != 1)
	return false;
elseif (!$this->isAdmin())
	return false;
$page = $this->getPage()->toArray();
$Form = $this->getHelper('nForm');
$Page = $this->getHelper('Settings\Page\Controller');
$Settings = $this->getHelper('Settings\Controller');
?>
<div class="start2 page-settings-editor">
	<h3 class="page-edit-title"><img src="/core/template/default/media/images/core/led_<?php echo  $page['page_live'] ?>.png" style="max-width: 20px; width: auto; display: inline;" />&nbsp;<?php echo $page['menu_name'] ?>&nbsp;&nbsp;<span style="color: red">|</span>&nbsp;&nbsp;<span class="white" id="path-domain"><?php echo  $page['full_path'] ?></span><a class="mini-btn green no-bx-shadow no-margin nTrigger" href="#" data-instructions='{"FX":{"event":["click"],"acton":["#page-settings"],"fxspeed":["fast","fast"],"fx":["slideToggle"]}}'>EDIT</a></h3>
	<div class="" style="background: linear-gradient(#666, #999); padding: 0.5em 1em 1em 1em; border-radius: 5px; box-shadow: 2px 2px 8px #000; <?php if ($this->getPost('action') != 'update_page') : ?>display: none;<?php endif ?>" id="page-settings">
		<?php echo $Form->open() ?>
		<?php echo $Form->fullhide(["name" => "action", "value" => "update_page", "class" => "nbr"]) ?>
		<?php echo $Form->fullhide(["name" => "token[nProcessor]", "value" => $this->getHelper('nToken')->getToken('page', false), "class" => "nbr"]) ?>
		<?php echo $Form->fullhide(["name" => "ID", "value" => $page['ID'], "class" => "nbr"]) ?>
		<?php echo $Form->fullhide(["name" => "unique_id", "value" => $page['unique_id'], "class" => "nbr"]) ?>
		<?php echo $Form->fullhide(["name" => "parent_id", "value" => $page['parent_id'], "class" => "nbr"]) ?>
		<?php echo $Form->fullhide(["name" => "link", "value" => $page['link'], "class" => "nbr"]) ?>

		<div class="col-count-4 gapped col-c2-md col-c1-sm page-editor-container">

			<div class="span4 span2-md span1-sm nTrigger pointer page-editor-header" data-instructions='{"FX":{"fx":["hide","accordian"],"acton":[".hide","next::slideDown"],"event":["click","click"],"fxspeed":["fast","fast"]}}'>
				<h3 class="no-margin no-padding arrow-down">Template Setup</h3>
			</div>
			<div class="span4 span2-md span1-sm hide" style="display: none;">
				<div class="col-count-2 gapped med-1 gapped">
					<div class="span2 span1-md">
						<p class="white" style="margin: 0;">This is what displays on the browser window title bar.</p>
						<?php echo $Form->text(['label' => 'Page Title', "name" => "menu_name", "value" => $page['menu_name'], "class" => "nbr", 'other' => ['required="required"']]) ?>
					</div>
					<div class="span2 span1-md">
						<p class="white" style="margin: 0;">This is the browser url path.</p>
						<?php echo $Form->text(['label' => 'Slug (URL Path)', "name" => "full_path", "value" => $page['full_path'], "class" => "nbr", 'other' => ['required="required"']]) ?>
					</div>
					<!--
 <?php echo $Form->text(['label' => '', "name" => "group_id", "value" => $page['group_id'], "class" => "nbr"]) ?>
 -->

					<div>
						<p class="white" style="margin: 0;">This tells the system how to treat this page.</p>
						<?php echo $Form->select(['label' => 'Page Type', "name" => "is_admin", "options" => [
							['name' => 'Common Page', 'value' => '', 'selected' => ($page['is_admin'] == '')],
							['name' => 'Admin Page', 'value' => 1, 'selected' => ($page['is_admin'] == 1)],
							['name' => 'Home Page', 'value' => 2, 'selected' => ($page['is_admin'] == 2)],
							['name' => 'Login Page', 'value' => 3, 'selected' => ($page['is_admin'] == 3)]
						], "class" => "nbr"]) ?>
					</div>

					<div>
						<p class="white" style="margin: 0;">This is a shortcode for the page type for development purposes.</p>
						<?php echo $Form->select(['label' => 'Page Shortcode', "name" => "page_type", "options" => \Nubersoft\nForm::getOptions('page_type', $page['page_type']), "class" => "nbr"]) ?>
					</div>

					<div>
						<p class="white" style="margin: 0;">If you have multiple templates, select which to use.</p>
						<?php echo $Form->select(['label' => 'Template', "name" => "template", "options" => array_map(function ($v) use ($page) {
							return [
								'selected' => ($page['template'] == $v['value']),
								'name' => $v['name'],
								'value' => $v['value']
							];
						}, $Page->getTemplateList()), "class" => "nbr"]) ?>
					</div>

					<div>
						<p class="white" style="margin: 0;">This will pull a page found inside the template selected instead of the index file.</p>
						<?php echo $Form->text(['label' => 'Use Template Sub-page', "name" => "use_page", "value" => $page['use_page'], "class" => "nbr"]) ?>
					</div>

				</div>
			</div>


			<div class="start1 span4 span2-md span1-sm nTrigger pointer page-editor-header" data-instructions='{"FX":{"fx":["hide","accordian"],"acton":[".hide","next::slideDown"],"event":["click","click"],"fxspeed":["fast","fast"]}}'>
				<h3 class="no-margin no-padding arrow-down">Page Caching</h3>
			</div>
			<div class="span4 span2-md span1-sm hide" style="display: none;">
				<div class="col-count-4 gapped col-c2-md col-c1-sm">
					<div class="start1">
						<?php echo $Form->select(['label' => 'Cache Page?', "name" => "auto_cache", "options" => [
							['name' => 'Off', 'value' => 'off', 'selected' => ($page['auto_cache'] == 'off')],
							['name' => 'On', 'value' => 'on', 'selected' => ($page['auto_cache'] == 'on')]
						], "class" => "nbr"]) ?>
					</div>
				</div>
			</div>

			<div class="start1 span4 span2-md span1-sm nTrigger pointer page-editor-header" data-instructions='{"FX":{"fx":["hide","accordian"],"acton":[".hide","next::slideDown"],"event":["click","click"],"fxspeed":["fast","fast"]}}'>
				<h3 class="no-margin no-padding arrow-down">Activation Settings</h3>
			</div>
			<div class="span4 span2-md span1-sm hide" style="display: none;">
				<div class="col-count-4 gapped col-c2-md col-c1-sm">
					<?php echo $Form->select(['label' => 'Page Live?', "name" => "page_live", "options" => [
						['name' => 'Off', 'value' => 'off', 'selected' => ($page['page_live'] == 'off')],
						['name' => 'On', 'value' => 'on', 'selected' => ($page['page_live'] == 'on')]
					], "class" => "nbr"]) ?>
					<?php echo $Form->select(['label' => 'Activate In Navigation?', "name" => "in_menubar", "options" => [
						['name' => 'Off', 'value' => 'off', 'selected' => ($page['in_menubar'] == 'off')],
						['name' => 'On', 'value' => 'on', 'selected' => ($page['in_menubar'] == 'on')]
					], "class" => "nbr"]) ?>
					<?php echo $Form->text(['label' => 'Navigation Bar Order', "name" => "page_order", "value" => $page['page_order'], "class" => "nbr"]) ?>
				</div>
			</div>

			<div class="start1 span4 span2-md span1-sm nTrigger pointer page-editor-header" data-instructions='{"FX":{"fx":["hide","accordian"],"acton":[".hide","next::slideDown"],"event":["click","click"],"fxspeed":["fast","fast"]}}'>
				<h3 class="no-margin no-padding arrow-down">Forwarding Settings</h3>
			</div>
			<div class="span4 span2-md span1-sm hide" style="display: none;">
				<div class="col-count-4 gapped col-c2-md col-c1-sm">
					<?php echo $Form->text(['label' => 'Forward to', "name" => "auto_fwd", "value" => $page['auto_fwd'], "class" => "nbr"]) ?>
					<?php echo $Form->select(['label' => 'Forward After Login?', "name" => "auto_fwd_post", "options" => [
						['name' => 'Off', 'value' => 'off', 'selected' => ($page['auto_fwd_post'] == 'off')],
						['name' => 'On', 'value' => 'on', 'selected' => ($page['auto_fwd_post'] == 'on')]
					], "class" => "nbr"]) ?>
				</div>
			</div>

			<div class="start1 span4 span2-md span1-sm nTrigger pointer page-editor-header" data-instructions='{"FX":{"fx":["hide","accordian"],"acton":[".hide","next::slideDown"],"event":["click","click"],"fxspeed":["fast","fast"]}}'>
				<h3 class="no-margin no-padding arrow-down">Permission Settings</h3>
			</div>
			<div class="span4 span2-md span1-sm hide" style="display: none;">
				<div class="col-count-4 gapped col-c2-md col-c1-sm">
					<?php echo $Form->select(['label' => 'Require Login?', "name" => "session_status", "options" => [
						['name' => 'Off', 'value' => 'off', 'selected' => ($page['session_status'] == 'off')],
						['name' => 'On', 'value' => 'on', 'selected' => ($page['session_status'] == 'on')]
					], "class" => "nbr"]) ?>

					<?php echo $Form->select(['label' => 'Usergroup Allowed', "name" => "usergroup", "options" => array_map(function ($v) use ($page) {
						if ($page['usergroup'] == $v['value'])
							$v['selected'] = true;

						return $v;
					}, $Settings->getFormAttr('users')['usergroup']['options']), "class" => "nbr"]) ?>
				</div>
			</div>

			<div class="start1 col-count-3 col-c2-lg col-c1-md"><?php echo $Form->checkbox(['label' => 'Delete Page?', 'name' => 'delete', 'value' => 'on']) ?></div>

			<div class="start1 span3 span2-md span1-sm col-count-6 col-c4-lg col-c2-md col-c1-sm">
				<?php echo $Form->submit(["name" => "", "value" => "SAVE", "class" => "nbr medi-btn dark"]) ?>
			</div>
		</div>
		<?php echo $Form->close() ?>
	</div>
	<h3 class="page-edit-title margin-top-1">Page Components</h3>
</div>
<script>
	$(function() {
		$('input[name="full_path"]').on('keyup change', function() {
			$('#path-domain').text($(this).val());
		});
	});
</script>