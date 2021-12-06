<h3>Available Tables</h3>
<p class="mb-5">These are the tables available in the database. Some are required to make the site work, some are for individual features.</p4
<?php foreach(\NubersoftCms\Model\Database::getTables() as $button):
    $interface  =   '';
    foreach($this->getDataNode('plugins')['paths'] as $path) {
        if(empty($interface)) {
            if(is_file($path.DS.'admintools'.DS.$button.DS.'interface.php')) {
                $interface  =   '&subaction=interface';
            }
        }
    }
?>
<div>
    <div class="mt-5 mb-3">
        <a href="?table=<?php echo $button.$interface ?>" class="sidebar <?php echo ($button == $this->getRequest('table'))? 'active' : '' ?>"><?php echo $this->colToTitle($button) ?></a>
    </div>
    <div>
        <table class="generic-table">
            <tablebody>
            <tr>
                <th>Column Name</th>
                <th>Column Type</th>
                <th>Allowed Empty</th>
                <th>Default Value</th>
                <th>Key Type</th>
                <th>Extra Info</th>
            </tr>
            <?php
            foreach(\NubersoftCms\Model\Database::getAttributes($button) as $attr):
                 $attr = new \NubersoftCms\Dto\Model\Database\AttributesResponse($attr->toArray())
            ?>
            <tr>
                <td><?php echo $attr->field ?></td>
                <td><?php echo $attr->type ?></td>
                <td><?php echo $attr->null ?></td>
                <td><?php echo $attr->default ?></td>
                <td><?php echo $attr->key ?></td>
                <td><?php echo $attr->extra ?></td>
            </tr>
            
            <?php endforeach ?>
            </tablebody>
        </table>
    </div>
</div>
<?php endforeach ?>