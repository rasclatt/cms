
<?php echo $this->getPlugin('admintools', DS.'users'.DS.'interface.php') ?>
<h3>User Accounts</h3>

<?php
$Pagination	=	$this->getHelper('SearchEngine\View')->fetch([
	'columns' => [
		'first_name',
		'last_name',
		'email',
		'username'
	],
    'max_range' => [
        10,20,50,100,500
    ],
    'spread' => 2,
	'sort' => 'DESC'
	],
	function($nQuery, $Pagination, $REQ){

		if(!empty($REQ['search'])) {
			$bind		=	array_fill(0,count($Pagination->columns),'%'.$Pagination->dec(urldecode($REQ['search'])).'%');
			
			foreach($Pagination->columns as $col) {
				$where[]	=	$col." LIKE ?";
			}
			
			$where	=	implode(' ',array_merge([" WHERE "],[implode(" OR ", $where)]));
		}
		else
			$where	=	'';
		
		$sql	=	"SELECT
						COUNT(*) as count
					FROM
						users
					{$where}";
		return $Pagination->query($sql,(!empty($bind)? $bind : null))->getResults(1)['count'];
	},
	function($REQ, $Pagination, $page, $limit, $orderB, $orderH){
		if(!empty($REQ['search'])) {
			$bind		=	array_fill(0,count($Pagination->columns),'%'.$Pagination->dec(urldecode($REQ['search'])).'%');
			
			foreach($Pagination->columns as $col) {
				$where[]	=	$col." LIKE ?";
			}
			
			$where	=	implode(' ',array_merge([" WHERE "],[implode(" OR ", $where)]));
		}
		else
			$where	=	'';
		
		$sql	=	"SELECT
						*
					FROM
						users
					{$where}
					ORDER BY
						".$orderB." ".$orderH."
					LIMIT
						{$page}, {$limit}";
		
		$results	=	$Pagination->query($sql,(!empty($bind)? $bind : null))->getResults();
		
		return (!empty($results))? array_map(function($v){
			$v['name']		=	$v['first_name'].' '.$v['last_name'];
			$v['avatar']	=	(!empty($v['file_path'].' '.$v['file_name']))? '<img src="'.$v['file_path'].' '.$v['file_name'].'" class ="user-avatar" />' : '';
			return $v;
		},$results) : [];
	});

$page_details	=	$Pagination->getAllButResults();
# Searchbar
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
	<?php foreach($Pagination->getResults() as $row): ?>
		<div class="col-count-7 table-row-container" onClick="window.location='?table=users&edit=<?php echo $row["ID"] ?>&subaction=interface'">
	<?php foreach($row as $key => $value):
				if(!in_array($key, ['ID', 'username', 'email', 'name','usergroup', 'user_status' ]))
					continue;
			?>
			<div style="overflow: hidden;" class="table-row"><?php echo ($key == 'usergroup' && !is_numeric($value))? constant($value) : $value ?></div>
	<?php endforeach ?>
			
			<div class="table-row"><a href="?table=users&edit=<?php echo $row["ID"] ?>subaction=interface" class="mini-btn dark">EDIT</a></div>
		</div>
	<?php endforeach ?>
	</div>
<?php endif;