<?php
# Create pagination
$Pagination	=	new \Nubersoft\Pagination($this->getGet('table'), $this->getGet('current'), $this->getGet('max'));
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
# Start form builder
$Form	=	@$this->nForm();
?>

<?php echo $this->getPlugin('table_view', DS.'interface.php') ?>

<h3>Table View</h3>
<p>Currently viewing <code><?php echo $this->getRequest('table') ?></code></p>
<div class="align-center search-bar-wrap-block">
    <?php
    # Searchbar
    echo $this->setPluginContent('page_details', $page_details)
        ->getPlugin('adminbar', 'searchbar.php');
    ?>
</div>

<div class="table-row-container-wrap">
    <?php 
    if(!empty($this->getRequest('create'))):
        echo $this->getPlugin('table_view', DS.'add.php');
    elseif(is_numeric($this->getRequest('edit'))):
        $result	=	@$this->nQuery()->query("SELECT * FROM ".$this->getRequest('table')." WHERE ID = ?", [$this->getRequest('edit')])->getResults(1);

        if(empty($result)) {
            $this->toError('Row is invalid.'); ?>
            <?php
            echo $this->getPlugin('notifications');
            return false;
        }

        $this->setNode('table_data', $result);
        echo $this->getPlugin('table_view', DS.'form.php');

        ?>
        <script>
        $(function(){
            $('input[name="delete"]').on('change',function(e){
                var	getVal	=	$(this).is(':checked');
                var	uSher	=	(getVal)? confirm('Do you really want to delete?') : true;
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
    <?php
    $cols	=	array_map(function($v){
        return \Nubersoft\nReflect::instantiate('\Nubersoft\nRender')->colToTitle($v['Field']);
    }, @$this->nQuery()->describe($this->getRequest('table')));

    ?>

        <div style="overflow: auto;">
            <table class="generic-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><?php echo implode('</td>'.PHP_EOL.'<td>',array_merge($cols, ['&nbsp;'])) ?></td>
                </tr>
            <?php foreach($page_details['results'] as $row): ?>
                <tr onClick="window.location='?table=<?php echo $this->getRequest('table') ?>&edit=<?php echo $row["ID"] ?>'" class="table-body-row">
            <?php foreach($row as $key => $value): ?>
                    <td>
                        <?php echo $value ?>
                    </td>
            <?php endforeach ?>

                    <td><a href="?table=<?php echo $this->getRequest('table') ?>&edit=<?php echo $row["ID"] ?>" class="mini-btn dark">EDIT</a></td>
                </tr>
            <?php endforeach ?>
            </table>
        </div>
    <?php endif ?>
</div>