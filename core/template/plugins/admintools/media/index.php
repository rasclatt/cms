<?php
use \Nubersoft\SearchEngine\View;

$Form = @$this->nForm();
?>

<h3>Media</h3>
<div class="pad-bottom-1 pad-top-1">
	<?php echo $this->getPlugin('admintools', DS . 'media' . DS . 'interface.php') ?>
</div>

<?php
$Pagination = (new View)->fetch(
	[
		'max_range' => [
			10, 20, 50, 100, 500
		],
		'columns' => [
			'file_name'
		],
		'spread' => 2,
		'sort' => 'DESC'
	],
	function ($nQuery, $Pagination, $REQ) {

		if (!empty($REQ['search'])) {
			$bind  = array_fill(0, count($Pagination->columns), '%' . $Pagination->dec(urldecode($REQ['search'])) . '%');

			foreach ($Pagination->columns as $col) {
				$where[] = $col . " LIKE ?";
			}

			$where = implode(' ', array_merge([" WHERE "], [implode(" OR ", $where)]));
		} else
			$where = '';

		$sql = "SELECT
      COUNT(*) as count
     FROM
      media
     {$where}";
		return $Pagination->query($sql, (!empty($bind) ? $bind : null))->getResults(1)['count'];
	},
	function ($REQ, $Pagination, $page, $limit, $orderB, $orderH) {
		if (!empty($REQ['search'])) {
			$bind  = array_fill(0, count($Pagination->columns), '%' . $Pagination->dec(urldecode($REQ['search'])) . '%');

			foreach ($Pagination->columns as $col) {
				$where[] = $col . " LIKE ?";
			}

			$where = implode(' ', array_merge([" WHERE "], [implode(" OR ", $where)]));
		} else
			$where = '';

		$sql = "SELECT
      				*
     			FROM
      				media
				{$where}
				ORDER BY
					" . $orderB . " " . $orderH . "
				LIMIT
					{$page}, {$limit}";

		$results = $Pagination->query($sql, (!empty($bind) ? $bind : null))->getResults();

		return (!empty($results)) ? array_map(function ($v) {
			$v['filename'] = $v['file_path'] . $v['file_name'];
			$v['image']  = (!empty($v['file_path'] . $v['file_name'])) ? '<img src="' . $v['file_path'] . $v['file_name'] . '" style="width: auto; height: auto; max-height: 200px;" />' : '';
			return $v;
		}, $results) : [];
	}
);

$page_details = $Pagination->getAllButResults();
# Searchbar
echo $this->setPluginContent('page_details', $page_details)
	->getPlugin('adminbar', 'searchbar.php');
?>


<script>
	$(function() {
		fetchAllTokens($);
	});
</script>

<?php
if (!empty($this->getRequest('create'))) :
	echo $this->getPlugin('admintools', DS . 'media' . DS . 'add.php');
elseif (is_numeric($this->getRequest('edit'))) :
	$this->setNode('media_data', $this->query("SELECT * FROM media WHERE ID = ?", [$this->getRequest('edit')])->getResults(1));
	echo $this->getPlugin('admintools', DS . 'media' . DS . 'form.php');
?>
	<script>
		$(function() {
			$('input[name="delete"]').on('change', function(e) {
				var getVal = $(this).is(':checked');
				var uSher = (getVal) ? confirm('Do you really want to delete this user?') : true;
				if (uSher) {
					$('.user-editor').find('input,select').prop('disabled', getVal);
					$(this).prop('disabled', false);
					$('.user-editor').find('input[type="submit"],input[name="action"],input[name="ID"],input[type=hidden]').prop('disabled', false);
				} else {
					$(this).prop("checked", false);
				}
			});
		});
	</script>

<?php else : ?>

	<script>
		$(function() {
			$('#uploadnew').on('submit', function(e) {
				e.preventDefault();
				AjaxEngine.formData($(this)[0], function(response) {
					console.log(response);
					default_action($(this), response);
				}, 1);
			});
		});
	</script>

	<div class="margin-bottom-1 pad-1" style="background-color: #EBEBEB;">
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

	<div class="media-table col-count-4 gapped col-c2-lg col-c1-md">
		<?php foreach ($Pagination->getResults() as $row) : ?>
			<div class="col-count-1" style="border: 1px solid #CCC;">
				<div style="background-image: url('/core/template/default/media/images/ui/transbkg.png'); height: auto; background-size: auto; padding: 0.25em;">
					<div style="min-height: 200px; background-image: url('<?php echo $row['filename'] ?>');background-size: contain; background-repeat: no-repeat; background-position: center; position: relative; width: 100%;">
					</div>
				</div>
				<div class="col-count-2 gapped margin-1">
					<div class="span2" style="padding: 1em 1em 0 1em;">
						<input type="text" value="<?php echo $row['file_path'] . $row['file_name'] ?>" onClick="this.select()" class="nbr" />
						<div class="pad-top-1" style="font-family: Arial;">
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td class="pad-right-1">ID</td>
									<td><?php echo $row['ID'] ?></td>
								</tr>
								<tr>
									<td class="pad-right-1">Name</td>
									<td><?php echo $row['file_name'] ?></td>
								</tr>
								<tr>
									<td class="pad-right-1">Size</td>
									<td><?php echo \Nubersoft\Conversion\Data::getByteSize($row['file_size'], ['from' => 'B', 'to' => 'MB', 'round' => 2, 'ext' => 'MB']) ?></td>
								</tr>
							</table>
						</div>
					</div>
					<a href="?table=media&edit=<?php echo $row['ID'] ?>&subaction=interface" class="nbr small button auto text-center">EDIT</a>

					<a href="<?php echo $row['filename'] ?>" class="nbr small auto text-center button" target="_blank">VIEW</a>
				</div>
			</div>

		<?php endforeach ?>
	</div>

<?php endif;
