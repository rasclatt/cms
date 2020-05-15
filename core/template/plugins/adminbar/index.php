<?php
if(!$this->isAdmin())
	return false;

$isAdminPg  =   ($this->getDataNode('routing')['is_admin'])?? false;
$editActive	=	(!empty($this->getSession('editor')))? "off" : "on";
$adminPage	=	($this->getPage('is_admin') == 1)? '/' : $this->getAdminPage('full_path').'?action=set_edit_mode&active=off';
$title		=	($this->getPage('is_admin') == 1)? "icn_home" : "gear";
$livetitle	=	($editActive == 'off')? "View Mode" : "Edit Mode";
$icn		=	($editActive == 'off')? 'view' : 'edit';
$imgpath	=	'/core/template/default/media/images';
$iconlib	=	[
	'' => $docicon = $this->localeUrl($imgpath."/core/icn_doc.png"),
	'1' => $this->localeUrl($imgpath."/core/gear.png"),
	'2' => $this->localeUrl($imgpath."/core/icn_home.png"),
	'3' => $docicon
];
?>
    
<nav id="admin-menubar">
	<div>
		<div id="window-width"></div>
		<div id="window-height"></div>
		<a href="<?php echo $this->localeUrl($adminPage) ?>"><img src="<?php echo $this->localeUrl($imgpath."/core/{$title}.png") ?>" style="max-height: 25px; width: auto; margin: 0;" /></a>
		<?php if($this->userGet('usergroup') <= 1): ?>
        
		<a href="<?php echo $this->localeUrl($this->getPage('full_path')."?action=set_edit_mode&active=".$editActive) ?>"><img src="<?php echo $this->localeUrl($imgpath."/core/icn_{$icn}.png") ?>" style="max-height: 25px; width: auto;" /></a>
		<?php endif ?>
        
		<div class="admin-menu">
			<img src="<?php echo $docicon ?>" style="max-height: 25px; width: auto;" />
			<div class="admin-submenu">
				<div class="page-menu">
					<?php echo $this->getHelper('\System\View\Menu')->create();?>
				</div>
                <?php if($this->userGet('usergroup') <= 1): ?>
				<div style="padding: 0.5em;">
					<?php
					$Form	=	@$this->nForm();
					echo $Form->open() ?>
					<?php echo $Form->fullhide(['name'=>'token[nProcessor]', 'value'=>'']) ?>
					<?php echo $Form->fullhide(['name'=>'action', 'value'=>'create_new_page']) ?>
					<?php echo $Form->submit(['value'=>'+PAGE','class'=>'medi-btn green']) ?>
					<?php echo $Form->close() ?>
				</div>
                <?php endif ?>
			</div>
		</div>
		<?php if(is_dir(NBR_CLIENT_CACHE) && count(scandir(NBR_CLIENT_CACHE)) > 2): ?>
		<div class="divider vertical light"></div>
		<a href="?action=clear_cache"><img src="<?php echo $this->localeUrl($imgpath."/buttons/deleteCache.png") ?>" style="max-height: 25px; width: auto;" class="pointer" title="Clear Cache" /></a>
		<?php endif ?>
		<div class="divider vertical light"></div>
		<a href="?action=logout"><i class="fas fa-sign-out-alt fa-2x pointer" title="Log Out"></i></a>
	</div>
</nav>
<script>
	$(function(){
		var win_w	=	$('#window-width');
		var win_h	=	$('#window-height');
		win_w.text('w: '+$(window).width()+'px /');
		win_h.html('&nbsp;h: '+$(window).height()+'px');
		
		$(window).on('resize', function(e){
			win_w.text('w: '+$(this).width()+'px /');
			win_h.html('&nbsp;h: '+$(this).height()+'px');
		});
	});
</script>