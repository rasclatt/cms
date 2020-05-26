<?php
# Create pagination
$Pagination	=	new \Nubersoft\Pagination('users', $this->getGet('current'), $this->getGet('max'));
# Extract table rows
$fields =   $Pagination->getColumnsInTable();
# If there is a search
if($this->getGet('search'))
    $Pagination->search("%".$this->getGet('search')."%", $fields, "LIKE");
# Order if row exists
if(isset($fields['ID']))
    $Pagination->orderBy('ID', 'DESC');
# Fetch results
$page_details	=	$Pagination->get();
?>

<?php echo $this->getPlugin('admintools', DS.'users'.DS.'interface.php') ?>
<h3>User Accounts</h3>

<?php
echo $this->setPluginContent('page_details', $page_details)
    ->getPlugin('adminbar', 'searchbar.php');

if(!empty($this->getRequest('create'))):
	echo $this->getPlugin('admintools', DS.'users'.DS.'add.php');

elseif(is_numeric($this->getRequest('edit'))):
	$user	=	$this->getHelper('nUser')->getUser($this->getRequest('edit'), 'ID');

	if(empty($user)) {
		$this->toError('User is invalid.'); ?>
		<?php
		echo $this->getPlugin('notifications');
		return false;
	}
   
   	$this->setNode('user_data', $user);
	echo $this->getPlugin('admintools', DS.'users'.DS.'form.php');
	
	?>
	<script>
	$(function(){
		$('input[name="delete"]').on('change',function(e){
			var	getVal	=	$(this).is(':checked');
			var	uSher	=	(getVal)? confirm('Do you really want to delete this user?') : true;
			if(uSher) {
				$('.user-editor').find('input,select').prop('disabled',getVal);
				$(this).prop('disabled', false);
				$('.user-editor').find('input[type="submit"],input[name="action"],input[name="ID"],input[type=hidden]').prop('disabled',false);
			}
			else {
				$(this).prop("checked", false);
			}
		});
	});	
	</script>
<?php else: ?>

	<div class="user-table">
		<div class="col-count-7 table-row-container">
			<div class="table-header"><?php echo implode('</div>'.PHP_EOL.'<div class="table-header">',['ID', 'Username', 'Email', 'Usergroup', 'Status','Name','&nbsp;' ]) ?></div>
		</div>
	<?php foreach($page_details['results'] as $row): ?>
		<div class="col-count-7 table-row-container" onClick="window.location='?table=users&edit=<?php echo $row["ID"] ?>&subaction=interface'">
	<?php foreach($row as $key => $value):
				if(!in_array($key, ['ID', 'username', 'email', 'name','usergroup', 'user_status' ]))
					continue;
			?>
			<div style="overflow: hidden;" class="table-row"><?php echo ($key == 'usergroup' && !is_numeric($value))? constant($value) : $value ?></div>
	<?php endforeach ?>
			
			<div class="table-row"><a href="?table=users&edit=<?php echo $row["ID"] ?>&subaction=interface" class="mini-btn dark">EDIT</a></div>
		</div>
	<?php endforeach ?>
	</div>
<?php endif;