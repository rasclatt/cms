<?php 
if(empty($this))
    throw new \Exception("Forbidden", 403);
?>
<h1>Create your registry file.</h1>
<p>This file is a hardcopy of settings to help your application run. If you don't know what it does, you may want to just leave it as is.</p>
<?php echo $Form->open() ?>
	<?php echo $Form->fullhide(['name'=>'action', 'value' => 'save_registry_doc', 'id' => 'registry-form']) ?>
<a href="#" class="add-new button gray">Add Define</a>
<table border="0" id="registry">
	<?php foreach($data as $key => $value): ?>
	<tr>
		<td><?php echo $key ?></td>
		<td><?php echo $Form->text(['name' => $key, 'value' => $value, 'class' => 'nbr required', 'other'=>['size="'.(strlen($value)*1.1).'"', 'required="required"']]) ?></td>
	</tr>
	<?php endforeach ?>
	<tr>
		<td colspan="2" class="align-right"><?php echo $Form->submit(['value' => 'Save', 'class' => 'button']) ?></td>
	</td>
</table>
<?php echo $Form->close() ?>
<script>
    $(function(){
	   $('.add-new').on('click', function(){
           $('#registry').prepend(
            '<tr class="new-reg-opt">' +
                '<td><input class="key-name nbr" placeholder="key" maxlength="30" /></td>' +
                '<td><?php echo trim(strip_tags($Form->text(['placeholder' => 'value', 'class' => 'nbr']), '<input>')) ?></td>'+
            '</tr>');
       });
        
        $(this).on('keyup', '.key-name', function(){
            
            let thisVal =   $(this).val().toUpperCase().replace(/[^A-Z]/gi, '_');
            $(this).val(thisVal);
            $(this).parents('.new-reg-opt').find('input').attr('name', thisVal);
        });
    });
</script>