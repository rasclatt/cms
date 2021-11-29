<?php
use \Nubersoft\nForm as Form;
# Create pagination
$Pagination	=	new \Nubersoft\Pagination('components', $this->getGet('current'), $this->getGet('max'));
# Extract table rows
$fields =   $Pagination->getColumnsInTable();
if($this->getGet('search'))
    $s =  $this->getGet('search');
else
    $s =    ($this->getCookie('language') && $this->getCookie('language') != 'en')? "us{$this->getCookie('language')}" : false;
# If there is a search
$Pagination->search($s, function($search) {
    $sql    =   "(component_type = 'transkey' OR category_id = 'translator')";
    if(!empty($search))
        $sql    .=  " AND (`title` LIKE ? OR `content` LIKE ?)";
    
    return $sql;
}, "LIKE");

if(!empty($s)) {
    $Pagination->addToBind($s = "%{$s}%")
        ->addToBind($s);
}

# Order if row exists
$Pagination->orderBy('timestamp', 'DESC');
# Fetch results
$page_details	=	$Pagination->get();
?>

<?php echo $this->getPlugin('admintools', 'admin_ui.php') ?>

<div class="span2">
    
    <div class="col-count-2 translator-mast" style="grid-template: 1fr / 1fr auto;">
        <h2>Translation Editor</h2>
        <?php echo $this->getPlugin('widget_locale' ,'language_menu'.DS.'index.php') ?>
    </div>
    
    <?php if(!empty($this->getGet('edit')) || !empty($this->getGet('search'))): ?>
    
    <div class="flexor margin-bottom-1 pad-1">
        <a href="<?php echo $this->getPage('full_path') ?>" class="button standard wb uppercase">Back</a>
    </div>
    
    <?php endif ?>
    
    <?php echo Form::getOpen(['id'=>'']) ?>
        <?php echo Form::getFullhide(['name' =>'action', 'value' => 'autogen_translator']) ?>
        <?php echo Form::getSubmit(['value' => 'Refresh', 'class' => 'button standard']) ?>
    <?php echo Form::getClose() ?>
    
    <div>
        <?php
        if(empty($this->getGet('edit')))
            echo str_replace('name="search"', 'name="search" autocomplete="off"', $this->setPluginContent('page_details', $page_details)
            ->getPlugin('adminbar', 'searchbar.php'));

        if(!empty($this->getRequest('create')))
            echo $this->getPlugin('admintools', DS.'users'.DS.'add.php')
        ?>
        
        <?php echo $this->setPluginContent('page_details', $page_details)
                ->getPlugin('admintools', 'adminnavigation'.DS.'table.php') ?>
    </div>
    
</div>
<style>
    #admin-content-wrap {
        grid-template: 1fr / 1fr !important;
    }
    .table-row-container:hover, tr.table-body-row:hover td {
        cursor: default;
    }
</style>
<script>
    $('#admin-sidebar').hide();
    
    $(function(){
	   $.each($('.main-button-nav a'), function(k, v){
           if($(v).attr('href').match(/^\?/gi)) {
               $(v).attr('href', `/wp-admin/${$(v).attr('href')}`);
           }
       });
    });
</script>