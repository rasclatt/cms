<?php include(__DIR__.DS.'var.php') ?>
<script>
function cfrsToken()
{
    if($('form').length == 0)
        return false;
    
    $.each($('form'), (k,v) => {
        if($(v).find('input[name="jwtToken"]').length == 0) {
            $(v).prepend(`<input type="hidden" name="jwtToken" class="jwtToken" value="${csrf}" />`);
        }
    });
}
$(function(){
	cfrsToken();
});
</script>
