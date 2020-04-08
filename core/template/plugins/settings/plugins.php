<?php
namespace Nubersoft;

$this->getPlugin('detect_plugins');
$this->isDir(NBR_CLIENT_PLUGINS, 1);
$plugins	=	array_values(array_diff(scandir(NBR_CLIENT_PLUGINS), ['.','..']));


//$this->deleteOption('widget_tester_bester');

?>
<h2>Widgets</h2>
<p>Acivate and deactivate web applications.</p>
<div class="col-count-2">
	<div class="span-2">
		<table class="no-margin children" style="width: 100%;" cellpadding="0" cellspacing="0" border="0">
			<tr class="table-tbl-row header">
				<th style="width: 80px">Active</th>
				<th>Description</th>
				<th>Author</th>
			</tr>
		<?php
		foreach($plugins as $plugin):
			$active	=	$this->getOption('widget_'.$plugin);
			$Widget	=	new Widget($plugin);
		?>

			<tr class="table-tbl-row">
				<td>
					<input type="checkbox" name="active_widget" value="<?php echo $this->enc($Widget->getSlug()) ?>" class="plugins"<?php if($Widget->isActive()):?> checked="checked"<?php endif ?> />
				</td>
				<td>
					<h4><?php echo $this->enc($Widget->getName()) ?></h4>
					<p style="margin: 0;"><?php echo $this->enc($Widget->getAuthor('description')) ?></p>
				</td>
				<td>
					<p style="margin: 0;"><?php echo $this->enc($Widget->getAuthor('name')); $email	= $Widget->getAuthor('email'); if(filter_var($email, FILTER_VALIDATE_EMAIL)):?> (<a href="mailto:<?php echo $email ?>"><?php echo $email ?></a>)<?php endif ?></p>
				</td>
				<!--
				<td>
					<?php if($Widget->isActive()): ?>
					<a href="?action=delete_widget&loadpage=load_settings_page&subaction=plugins&slug=<?php echo $this->enc($Widget->getslug()) ?>" style="text-decoration: none; padding: 0.5em 1em; border-radius: 4px; background-color: #CCC;">DELETE</a>
					<?php endif ?>
				</td>
				-->
			</tr>

		<?php endforeach ?>
		</table>
	</div>
</div>
<script>
	$(function(){
		$('input[name="active_widget"]').on("change", function(e){
			var	doact	=	$(this).is(":checked")? '' : 'de';
			var active	=	confirm('Are you sure you want to '+doact+'activate the widget?');
			var url	=	'?action='+doact+'activate_widget&loadpage=load_settings_page&subaction=plugins&slug='+$(this).val();
			if(active){
				window.location	=	url;
			}
			else {
				$(this).prop('checked',(doact == 'de'));
			}
		});
	});
</script>