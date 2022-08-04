<?php
$id = $this->getPluginContent('check_id');
$name = $this->getPluginContent('check_name');
if(empty($name))
    $name = 'delete';
?>
<div class="fancy-box-container">
    <label for="<?php echo $id ?>" class="unstyled">Delete?</label>
    <div class="fancy-box-wrap">
        <input type="checkbox" name="<?php echo $name ?>" value="on" id="<?php echo $id ?>" />
        <label class="fancy-box unstyled" for="<?php echo $id ?>"></label>
    </div>
</div>