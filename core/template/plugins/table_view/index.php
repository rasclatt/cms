<?php
$Form	=	@$this->nForm();
$Pagination	=	$this->getHelper('SearchEngine\View')->fetch([
    'max_range' => [
        10,20,50,100,500
    ],
    'spread' => 2,
    'columns' => $this->getDataNode("table_data"),
    'sort' => 'DESC'
    ],
    function($nQuery, $Pagination, $REQ){

        if(!empty($REQ['search'])) {
            $bind		=	array_fill(0,count($Pagination->getColumnsAllowed()),'%'.$Pagination->dec(urldecode($REQ['search'])).'%');

            foreach($Pagination->getColumnsAllowed('`') as $col) {
                $where[]	=	$col." LIKE ?";
            }

            $where	=	implode(' ',array_merge([" WHERE "],[implode(" OR ", $where)]));
        }
        else
            $where	=	'';

        $sql	=	"SELECT
                        COUNT(*) as count
                    FROM
                        ".$Pagination->getRequest('table')."
                    {$where}";

        return $Pagination->query($sql,(!empty($bind)? $bind : null))->getResults(1)['count'];
    },
    function($REQ, $Pagination, $page, $limit, $orderB, $orderH){
        if(!empty($REQ['search'])) {
            $bind		=	array_fill(0,count($Pagination->getColumnsAllowed()),'%'.$Pagination->dec(urldecode($REQ['search'])).'%');

            foreach($Pagination->getColumnsAllowed('`') as $col) {
                $where[]	=	$col." LIKE ?";
            }

            $where	=	implode(' ',array_merge([" WHERE "],[implode(" OR ", $where)]));
        }
        else
            $where	=	'';

        $sql	=	"SELECT
                        *
                    FROM
                        ".$Pagination->getRequest('table')."
                    {$where}
                    ORDER BY
                        ".$orderB." ".$orderH."
                    LIMIT
                        {$page}, {$limit}";

        $result	=	$Pagination->query($sql,(!empty($bind)? $bind : null))->getResults();
        return (!empty($result))? $result : [];
    });

$page_details	=	$Pagination->getAllButResults();
?>

<?php echo $this->getPlugin('table_view', DS.'interface.php') ?>

<h3>Table View</h3>
<div class="align-middle search-bar-wrap-block">
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
        return \Nubersoft\nApp::call()->getHelper('nRender')->colToTitle($v['Field']);
    }, @$this->nQuery()->describe($this->getRequest('table')));

    ?>

        <div style="overflow: auto;">
            <table class="generic-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><?php echo implode('</td>'.PHP_EOL.'<td>',array_merge($cols, ['&nbsp;'])) ?></td>
                </tr>
            <?php foreach($Pagination->getResults() as $row): ?>
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