<div class="sidebar">
    
    <div class="icn-table">
        <a href="#" class="canceller nTrigger" data-instructions='{"FX":{"fx":["slideToggle"],"acton":[".sidebar.submenu"],"event":["click"],"fxspeed":["fast"]}}'><span>Tables&nbsp;</span><i class="fas fa-chevron-down"></i></a>
    </div>
    
	<div class="sidebar submenu">
		<?php foreach(array_map(function($v){ return $v['Tables_in_'.base64_decode(DB_NAME)]; }, @$this->nQuery()->query("show tables")->getResults()) as $button):
            $interface  =   '';
            foreach($this->getDataNode('plugins')['paths'] as $path) {
                if(empty($interface)) {
                    if(is_file($path.DS.'admintools'.DS.$button.DS.'interface.php')) {
                        $interface  =   '&subaction=interface';
                    }
                }
            }
        ?>
		<a href="?table=<?php echo $button.$interface ?>" class="sidebar <?php echo ($button == $this->getRequest('table'))? 'active' : '' ?>"><?php echo $this->colToTitle($button) ?></a>
		<?php endforeach ?>
	</div>
</div>