<?php
$success	=	array_unique($this->getSystemMessages('success'));
$errors		=	array_unique($this->getSystemMessages('errors'));
$msg		=	(!empty($this->getRequest('msg')))? $this->getRequest('msg') : false;
?>

<?php if(!empty($errors)): ?>
	<div class="col-2">
		<div class="nbr_error pointer"><?php echo implode('</div><div class="nbr_error">', $errors) ?></div>
	</div>
<?php elseif(!empty($success)): ?>
	<div class="col-2">
		<div class="nbr_success pointer"><?php echo implode('</div><div class="nbr_success">', $success) ?></div>
	</div>
<?php elseif(!empty($msg)): ?>

	<div class="col-2">
		<div class="nbr_warning pointer<?php if($delay == 'off') echo ' stay' ?>"><?php
            echo $this->getHelper('ErrorMessaging')->getMessageAuto($this->getHelper('nCrypt')->decOpenSSL(urldecode($msg)));
            ?><span class="close-x">&times;</span></div>
	</div>

<?php endif ?>
<script>
	$(function(){
		let errormsgs =   $('.nbr_warning, .nbr_success, .nbr_error');
        
		<?php if($this->isAdmin()): ?>
        $.each(errormsgs, function(k, v){
            if(!$(v).hasClass('stay')) {
                $(v).delay(3000).slideUp('fast');
            }
        });
		<?php endif ?>
        
		errormsgs.on('click', function(){
			$(this).slideUp('fast');
		});
	});
</script>