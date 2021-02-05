<?php $data = $this->getPluginContent('modal') ?>
<div class="modal-container">
	<div class="modal-wrapper">
		<div class="modal-bar">
			<div><?php if(!empty($data['title'])) echo $data['title'] ?></div>
			<div class="nTrigger last-col pointer white align-middle" data-instructions='{"DOM":{"event":["click"],"html":[" "],"sendto":["#loadspot-modal"]}}'><i class="fas fa-times fa-2x pointer"></i></div>
		</div>
		<div class="modal-content">
			<?php if(!empty($data['html'])) echo $data['html'] ?>
		</div>
	</div>
</div>
<script>
	$(document).on('keyup', function(e){
		if(e.keyCode == 27) {
			$('#loadspot-modal').html('');
		}
	});
	
	function sizeContentWindow()
	{
		var wrapper_h	=	$('.modal-wrapper').height();
		$('.modal-content').height(wrapper_h - 115);
	}
	
	sizeContentWindow();
	
	$(window).on('resize', function(){
		sizeContentWindow();
	});
</script>