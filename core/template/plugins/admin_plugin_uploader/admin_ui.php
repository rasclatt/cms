<?php use \Nubersoft\nForm as Form ?>
<h3>Install Plugin</h3>
<p>Upload a zip file containing the appropriate files to activate a template plugin.</p>

<?php echo Form::getOpen([ 'action' => '#', 'id' => 'upload-zip', 'enctype' => 'multipart/form-data' ]) ?>
    <?php echo Form::getFullhide([ 'name' => 'action', 'value' => 'upload_plugin' ]) ?>
    <?php echo Form::getFullhide([ 'name' => 'subaction', 'value' => 'install' ]) ?>
    <?php echo (new Form)->file([ 'label' => 'Plugin Zip', 'name' => 'file', 'class' => 'nbr' ]) ?>
    <?php echo Form::getSubmit([ 'value' => 'Install', 'class' => 'nbr auto' ]) ?>
<?php echo Form::getClose() ?>