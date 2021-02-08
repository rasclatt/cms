<?php include(__DIR__.DS.'var.php') ?>
<script>
function cfrsToken()
{
    $('form').prepend(`<input type="hidden" name="jwtToken" class="jwtToken" value="${csrf}" />`);
}
$(function(){
	cfrsToken();
});
</script>
