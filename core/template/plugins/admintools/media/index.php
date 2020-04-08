<?php
$Form	=	@$this->nForm();
//echo $this->getPlugin('admintools', DS.'media'.DS.'interface.php') ?>

<h3>Media</h3>

<?php
$Pagination	=	$this->getHelper('SearchEngine\View')->fetch([
	'columns' => [
		'file_name'
	],
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
						media
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
						media
					{$where}
					ORDER BY
						".$orderB." ".$orderH."
					LIMIT
						{$page}, {$limit}";
		
		$results	=	$Pagination->query($sql,(!empty($bind)? $bind : null))->getResults();
		
		return (!empty($results))? array_map(function($v){
			$v['filename']	=	$v['file_path'].$v['file_name'];
			$v['image']		=	(!empty($v['file_path'].$v['file_name']))? '<img src="'.$v['file_path'].$v['file_name'].'" style="width: auto; height: auto; max-height: 200px;" />' : '';
			return $v;
		},$results) : [];
	});

$page_details	=	$Pagination->getAllButResults();

?>
<div class="col-count-5" id="search-bar">
	<div class="col-count-12 lrg-10 med-6 sml-5 search-bar max-range">
		<?php foreach($page_details['max_range'] as $num): ?>
		<div class="pagination-max"><a href="?<?php echo http_build_query(['max' => $num, "table" => 'media', 'current' => $page_details['current'], 'search' => $this->getGet('search')]) ?>&subaction=interface"><?php echo $num ?></a></div>
		<?php endforeach ?>
	</div>
	<div class="col-count-8 search-bar navigator">
		
		<?php if($page_details['previous'] !== 1 && !empty($page_details['previous'])): ?>
		<div class="pagination-max"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => 'media', 'current' => $page_details['previous'], 'search' => $this->getGet('search')]) ?>&subaction=interface">&lt;</a></div>
		<?php endif ?>
		<?php foreach($page_details['range'] as $num): ?>
		<div class="pagination-max"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => 'media', 'current' => $num, 'search' => $this->getGet('search')]) ?>&subaction=interface"><?php echo $num ?></a></div>
		<?php endforeach ?>
		<?php if(!empty($page_details['next'])): ?>
		<div class="pagination-max"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => 'media', 'current' => $page_details['next'], 'search' => $this->getGet('search')]) ?>&subaction=interface">&gt;</a></div>
		<?php endif ?>
	</div>
	<div class="search-bar search span-3">
		<?php echo $Form->open(["method"=>'get','action'=>'?'.http_build_query(['max' => $this->getGet('max'), "table" => 'media', 'search' => $this->getGet('search'), 'subaction'=>'interface']),'style' => 'width: 100%;']) ?>
			<?php echo $Form->fullhide(['name' => 'max', 'value' => $this->getGet('max')]) ?>
			<?php echo $Form->fullhide(['name' => 'table', 'value' => $this->getGet('table')]) ?>
			<div class="col-count-4">
				<div class="span-3">
					<?php echo $Form->text(['name' => 'search', 'value' => $this->getGet('search'), 'class'=>'nbr']) ?>
				</div>
				<div>
				<?php echo $Form->submit(['value' => 'Search', 'class'=>'button']) ?>
				</div>
			</div>
		<?php echo $Form->close() ?>
	</div>
</div>
<?php //echo printpre($page_details); ?>

<?php
if(!empty($this->getRequest('create'))):
	echo $this->getPlugin('admintools', DS.'media'.DS.'add.php');

elseif(is_numeric($this->getRequest('edit'))):
	$user	=	$this->getHelper('nUser')->getUser($this->getRequest('edit'), 'ID');

	if(empty($user)) {
		$this->toError('User is invalid.'); ?>
		<?php
		echo $this->getPlugin('notifications');
		return false;
	}
   
   	$this->setNode('user_data', $user);
	echo $this->getPlugin('admintools', DS.'media'.DS.'form.php');
	
	?>
	<script>
	$(function(){
		$('input[name="delete"]').on('change',function(e){
			var	getVal	=	$(this).is(':checked');
			var	uSher	=	(getVal)? confirm('Do you really want to delete this user?') : true;
			if(uSher) {
				$('#user-editor').find('input,select').prop('disabled',getVal);
				$(this).prop('disabled', false);
				$('#user-editor').find('input[type="submit"],input[name="action"],input[name="ID"],input[type=hidden]').prop('disabled',false);
			}
			else {
				$(this).prop("checked", false);
			}
		});
	});	
	</script>
<?php else: ?>
	<script>
		$(function(){
			
			$('#uploadnew').on('submit', function(e){
				e.preventDefault();
				AjaxEngine.formData($(this)[0], function(response){
                    console.log(response);
					default_action($(this), response);
				}, 1);
			});
		});
	</script>

	<div style="padding: 1em; background-color: #EBEBEB;">
		<h3>Upload File</h3>
		<form id="uploadnew" enctype="multipart/form-data">
			<input type="hidden" name="token[nProcessor]" value="" />
			<input type="hidden" name="action" value="edit_table_rows_details" />
			<input type="hidden" name="table" value="media" />
			<div class="col-count-5 gapped lrg-3 med-2 sml-1 ">
				<div class="align-middle">
					<label><input type="file" name="file[]" class="nbr" multiple /></label>
				</div>
				<input type="submit" name="Upload" class="button" />
			</div>
		</form>
	</div>

	<div class="media-table col-count-4 gapped lrg-2 med-1">
		<?php foreach($Pagination->getResults() as $row): ?>
		<div class="col-count-1" style="border: 1px solid #CCC;">
			<div style="background-image: url('/core/template/default/media/images/ui/transbkg.png'); height: 200px; background-size: auto; padding: 1em;">
				<div style="height: inherit; background-image: url('<?php echo $row['filename'] ?>');background-size: contain; background-repeat: no-repeat; background-position: center; position: relative; width: 100%;">
				</div>
			</div>
			<div class="col-count-2 gapped">
				<div class="span-2" style="padding: 1em 1em 0 1em;">
					<input type="text" value="<?php echo $row['file_path'].$row['file_name'] ?>" onClick="this.select()" class="nbr" />
					<div class="col-count-3 gapped pad-top-xsmall" style="font-family: Arial;">
						<div>ID</div><div class="span-2"><?php echo $row['ID'] ?></div>
						<div>Name</div><div class="span-2"><?php echo $row['file_name'] ?></div>
						<div>Size</div><div class="span-2"><?php echo \Nubersoft\Conversion\Data::getByteSize($row['file_size'], ['from'=>'B', 'to'=>'MB', 'round' =>2, 'ext' => 'MB']) ?></div>
					</div>
				</div>
				<a href="?table=media&edit=<?php echo $row['ID'] ?>" class="nbr button" style="width: auto !important; border-radius: 0;">EDIT</a>
				
				<a href="<?php echo $row['filename'] ?>" class="nbr button" style="width: auto !important; border-radius: 0;" target="_blank">VIEW</a>
			</div>
		</div>
		
		<?php endforeach ?>
	</div>

<?php endif;