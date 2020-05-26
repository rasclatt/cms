<?php
$success	=	array_unique($this->getSystemMessages('success'));
$errors		=	array_unique($this->getSystemMessages('errors'));
$msg		=	(!empty($this->getRequest('msg')))? $this->getRequest('msg') : false;
?>

<?php if(!empty($errors)): ?>
	<div>
		<div class="nbr_error pointer"><?php echo implode('</div><div class="nbr_error">', $errors) ?></div>
	</div>
<?php elseif(!empty($success)): ?>
	<div>
		<div class="nbr_success pointer"><?php echo implode('</div><div class="nbr_success">', $success) ?></div>
	</div>
<?php elseif(!empty($msg)): ?>

	<div>
		<div class="nbr_warning pointer<?php if(!empty($delay) && ($delay == 'off')) echo ' stay' ?>"><?php
            $decode    =   urldecode($msg);
            $decrypt    =   $this->getHelper('nCrypt')->decOpenSSL($decode);
            echo $this->getHelper('ErrorMessaging')->getMessageAuto($decrypt);
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