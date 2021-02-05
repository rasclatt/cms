<?php
$Form	=	$this->getHelper('nForm');
$page_details   =   $this->getPluginContent('page_details');
$spread =   (isset($page_details['range']))? $page_details['range'] : $page_details['spread'];
$previous =   (isset($page_details['previous']))? $page_details['previous'] : $page_details['prev'];
$interface  =   $this->getGet('subaction') == 'interface';

$path =   function($load, $current, $max, $table, $search, $other = [])
{
    return http_build_query(array_merge([
        'load' => $load,
        'current' => $current,
        'max' => $max,
        "table" => $table,
        'search' => $search
    ], $other));
};

$page_details['total_pages']    =   ($page_details['total_pages'])?? false;
//echo printpre($page_details);
?>

<style>
    #pagination-max,
    #pagination-pages{
        display: flex;
        flex-direction: row;
    }
    .pagination-wrap a {
        background-color: #2669BE;
        color: #FFF;
        padding: 0.35em 0.65em;
        font-size: 0.85em;
        transition: background-color 0.35s;
    }
    .pagination-wrap div:first-child a {
        border-top-left-radius: 1em;
        border-bottom-left-radius: 1em;
    }
    .pagination-wrap div:last-child a {
        border-top-right-radius: 1em;
        border-bottom-right-radius: 1em;
    }
    .pagination-wrap div:not(:last-child) {
        border-right: 1px solid #FFF;
    }
    .pagination-wrap a:hover,
    .pagination-max.active a {
        background-color: #CCC;
    }
    .pagination-wrap a:hover {
        color: #000;
    }
    #search-bar {
        display: grid;
        grid-template-columns: 1fr auto;
    }
    @media all and (max-width: 375px) {
        #search-bar {
            grid-template-columns: 1fr ;
        }
    }
</style>
<?php //echo printpre($page_details) ?>
<div class="col-count-3 gapped col-c1-lg">
    
    <div class="align-middle pad-bottom-1">
        <div id="pagination-max" class="pagination-wrap">
            <?php if(isset($page_details['per_page']) && !in_array($page_details['per_page'], $page_details['max_range'])) {
                $page_details['max_range']  =   array_merge([$page_details['per_page']], $page_details['max_range']);
                asort($page_details['max_range']);
            }
            foreach($page_details['max_range'] as $num): ?>
            <div class="pagination-max <?php if($num == $page_details['per_page']) echo ' active' ?>">
                <a href="?<?php echo $path($this->getGet('load'), $page_details['current'], $num, $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><?php echo $num ?></a>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    
    <div class="align-middle pad-bottom-1">
        <div id="pagination-pages" class="pagination-wrap">

            <?php if($page_details['current'] > 1 && $page_details['total_pages'] > 1): ?>
            <div class="pagination-max">
                <a href="?<?php echo $path($this->getGet('load'), 1, $this->getGet('max'), $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></a>
            </div>
            <?php endif ?>

            <?php if($page_details['current'] > 1): ?>

            <div class="pagination-max<?php if($num == $page_details['current']) echo ' active' ?>">
                <a href="?<?php echo $path($this->getGet('load'), $previous, $this->getGet('max'), $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><i class="fas fa-chevron-left"></i></a>
            </div>

            <?php endif ?>

            <?php foreach($spread as $num): ?>

            <div class="pagination-max<?php if($num == $page_details['current']) echo ' active' ?>">
                <a href="?<?php echo $path($this->getGet('load'), $num, $this->getGet('max'), $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><?php echo $num ?></a>
            </div>

            <?php endforeach ?>

            <?php if(isset($page_details['total_pages']) && (($page_details['total_pages'] != $page_details['current']) && $page_details['total_pages'] > 1)): ?>

            <div class="pagination-max<?php if($num == $page_details['current']) echo ' active' ?>">
                <a href="?<?php echo $path($this->getGet('load'), ($page_details['total_pages'] != $page_details['current'])? $page_details['current']+1 : $page_details['current'], $this->getGet('max'), $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><i class="fas fa-chevron-right"></i></a>
            </div>

            <?php endif ?>

            <?php if(isset($page_details['total_pages']) && (($page_details['total_pages'] > 1) && ($page_details['total_pages'] != $page_details['current']))): ?>

            <div class="pagination-max<?php if($num == $page_details['current']) echo ' active' ?>">
                <a href="?<?php echo $path($this->getGet('load'), $page_details['total_pages'], $this->getGet('max'), $this->getGet('table'), $this->getGet('search')); if($interface): ?>&subaction=interface<?php endif ?>"><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></a>
            </div>

            <?php endif ?>
        </div>
    </div>
    
    <?php if(isset($page_details['total_rows']) && $page_details['total_rows'] > 0): ?>
    
    <div class="align-middle pad-bottom-1">
        <?php echo $page_details['total_rows'] ?> Items
    </div>
    
    <?php endif ?>
    
</div>

<div id="search-bar-wrap">
    <div class="search-bar search">
        <?php echo $Form->open(["method"=>'get']) ?>
        
            <?php echo $Form->fullhide(['name' => 'subaction', 'value' => ($interface)? 'interface' : '']) ?>
            <?php echo $Form->fullhide(['name' => 'load', 'value' => $this->getGet('load')]) ?>
            <?php echo $Form->fullhide(['name' => 'max', 'value' => ($page_details['per_page'])?? false ]) ?>
            <?php echo $Form->fullhide(['name' => 'table', 'value' => $this->getGet('table')]) ?>
            <?php if($interface): ?>
            <?php echo $Form->fullhide(['name' => 'subaction', 'value' => 'interface']) ?>
            <?php endif ?>
            <div id="search-bar">
                <?php echo $Form->text(['name' => 'search', 'value' => $this->getGet('search'), 'class'=>'nbr']) ?>
                <?php echo $Form->submit(['value' => 'Search', 'class'=>'button']) ?>
            </div>
        <?php echo $Form->close() ?>
    </div>
</div>