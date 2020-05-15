<?php
$Form	=	$this->getHelper('nForm');
$page_details   =   $this->getPluginContent('page_details');
$interface  =   $this->getGet('subaction') == 'interface';
?>
<div class="col-count-5 lrg-1" id="search-bar">
    <div class="align-middle push-col-1 large">
        <div class="col-count-12 lrg-10 med-6 sml-5 search-bar max-range">
            <?php foreach($page_details['max_range'] as $num): ?>
            <div class="pagination-max <?php if($num == $this->getGet('max')) echo ' active' ?>"><a href="?<?php echo http_build_query(['max' => $num, "table" => $this->getGet('table'), 'current' => $page_details['current'], 'search' => $this->getGet('search')]); if($interface): ?>&subaction=interface<?php endif ?>"><?php echo $num ?></a></div>
            <?php endforeach ?>
        </div>
    </div>
	<div class="push-col-1 large search-bar navigator align-middle">
		<div class="col-count-8">
            <?php if(!empty($page_details['range'])): ?>
            <span class="small">pg </span>
            <?php endif ?>
            <?php if($page_details['previous'] !== 1 && !empty($page_details['previous'])): ?>
            
            <div class="pagination-max<?php if($num == $this->getGet('current')) echo ' active' ?>"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => $this->getGet('table'), 'current' => $page_details['previous'], 'search' => $this->getGet('search')]); if($interface): ?>&subaction=interface<?php endif ?>">&lt;</a></div>
            
            <?php endif ?>
            
            <?php foreach($page_details['range'] as $num): ?>
            
            <div class="pagination-max<?php if($num == $this->getGet('current')) echo ' active' ?>"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => $this->getGet('table'), 'current' => $num, 'search' => $this->getGet('search')]); if($interface): ?>&subaction=interface<?php endif ?>"><?php echo $num ?></a></div>
            <?php endforeach ?>
            
            <?php if(!empty($page_details['next'])): ?>
            <div class="pagination-max<?php if($num == $this->getGet('current')) echo ' active' ?>"><a href="?<?php echo http_build_query(['max' => $this->getGet('max'), "table" => $this->getGet('table'), 'current' => $page_details['next'], 'search' => $this->getGet('search')]); if($interface): ?>&subaction=interface<?php endif ?>">&gt;</a></div>
            
            <?php endif ?>
        </div>
	</div>
	<div class="push-col-1 large search-bar search span-3">
		<?php echo $Form->open(["method"=>'get','action'=>'?'.http_build_query(['max' => $this->getGet('max'), "table" => $this->getGet('table'), 'search' => $this->getGet('search'), 'subaction'=> ($interface)? 'interface' : ''])]) ?>
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