<?php 
$page_details   =   $this->getPluginContent('page_details');
$table  =   'components';
?>

<div class="table-row-container-wrap">
    <?php 
    if(!empty($this->getRequest('create'))):
    
    
        echo $this->getPlugin('table_view', DS.'add.php');
    
    
    elseif(is_numeric($this->getRequest('edit'))):
        $result	=	@$this->nQuery()->query("SELECT * FROM ".$table." WHERE ID = ?", [$this->getRequest('edit')])->getResults(1);

        if(empty($result)) {
            $this->toError('Row is invalid.'); ?>
            <?php
            echo $this->getPlugin('notifications');
            return false;
        }

        echo $this->setPluginContent('table_data', $result)->getPlugin('admintools', 'adminnavigation'.DS.'form.php');

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
    $validCols  =   [];
    $cols	=	array_filter(array_map(function($v) use (&$validCols){
        if(preg_match('/^file|admin|ref_|user|parent|group|cache|page_order|unique|ID/', $v['Field']))
            return false;
        $validCols[]    =   $v['Field'];
        
        if($v['Field'] == 'title')
            return 'Trans Key';
        elseif($v['Field'] == 'category_id')
            return 'Type';
        
        return \Nubersoft\nReflect::instantiate('\Nubersoft\nRender')->colToTitle($v['Field']);
    }, @$this->nQuery()->describe($table)));

    ?>

        <div style="overflow: auto;">
            <table class="generic-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><?php echo implode('</td>'.PHP_EOL.'<td>',array_merge($cols, ['&nbsp;'])) ?></td>
                </tr>
            <?php foreach($page_details['results'] as $row): ?>
                <tr class="table-body-row">
            <?php foreach($row as $key => $value):
                    if(in_array($key, $validCols)): ?>
                    
                    <td <?php if($row['category_id'] != 'translator' && $key == 'category_id'): ?> class="pointer" onClick="window.location='?transkey=<?php echo $table ?>&edit=<?php echo $row["ID"] ?>'"<?php endif ?>>
                        <?php 
                        switch($key) {
                            case('title'):
                                $lang   =   substr($value, -2, 2);
                                echo $value;
                                break;
                            case('component_type'):
                                if($row['category_id'] == 'translator')
                                    echo "<img src=\"/core/template/nubersoft2020/images/flag-{$lang}.jpeg\" style=\"height: 1em; width: 1em; display: inline-block;\" />&nbsp;".strtoupper($lang);
                                break;
                            case('category_id'):
                                echo ($value == 'translator')? '<i class="fas fa-language"></i>' : '<i class="fas fa-key"></i>';
                                break;
                            default:
                                echo $value;
                        } ?>
                    </td>
                    
                    <?php endif ?>
            <?php endforeach ?>

                    <td><a href="?edit=<?php echo $row["ID"] ?>" class="mini-btn dark">EDIT</a></td>
                </tr>
            <?php endforeach ?>
            </table>
        </div>
    <?php endif ?>
</div>