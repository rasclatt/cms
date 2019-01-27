<div class="modal-container">
	<div class="modal-wrapper">
		<div class="modal-bar">
			<div><?php echo $this->getPluginContent('modal')['title'] ?></div>
			<div class="nTrigger last-col" data-instructions='{"DOM":{"event":["click"],"html":[" "],"sendto":["#loadspot-modal"]}}'></div>
		</div>
		<div class="modal-content">
			<?php echo $this->getPluginContent('modal')['html'] ?>
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