<div style="background-color: #d9d5d5; padding: 1em;">
<?php
$setRequired    =   function($html)
{
    return str_replace(['<label>','class="nbr"'],['<label class="required">','class="nbr" required'], $html); 
};
# Set the custom interface
$action['subaction']    =   'interface';
# If editing, add that to query string
if(is_numeric($this->getGet('edit'))) {
    $action['edit'] =   $this->getGet('edit');
}
$user	=	$this->getDataNode("user_data");
$this->removeNode("user_data");
$inputs	=	$this->getHelper('Settings\Controller')->getFormAttr($this->getRequest('table'));
$Form	=	$this->getHelper('nForm');
echo $Form->open(['id'=>'user-editor', 'action' => '?'.http_build_query($action), 'class' => 'user-editor','enctype'=>'multipart/form-data']);
echo $Form->fullhide(['name' => 'action', 'value' => 'edit_user_details']);
echo $Form->fullhide(['name' => 'table', 'value' => 'users']);
echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
?>

	
<?php
foreach($user as $field => $value):
	if(in_array($field, ['ID','unique_id'])) {
		$inputs[$field]['column_type']	=	'fullhide';
	}

	$keyset	=	(!empty($inputs[$field]['column_type']));
        
        ob_start();
        ?>
        
		<div<?php if($keyset && $inputs[$field]['column_type'] == 'fullhide'): ?> style="display: none;"<?php endif ?>>
		<?php
		if(empty($value))
			$value	=	$this->getPost($field);
		
		$label	=	$this->colToTitle($field);
		if(isset($inputs[$field])) {
			switch($inputs[$field]['column_type']) {
				case('fullhide'):
					echo $Form->fullhide([ 'name'=> $field, 'value' => $value]);
					break;
				case('hidden'):
					echo $Form->hidden(['name'=> $field, 'value' => $value]);
					break;
				case('text'):
					echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
					break;
				case('password'):
					echo $Form->password(['label' => $label, 'name'=> $field, 'value' => '', 'class' => 'nbr']);
					break;
				case('file'):
					echo $Form->file(['name'=> $field, 'value' =>'', 'class' => 'nbr']);
					break;
				case('select'):
					echo $Form->select(['label' => $label, 'name'=> $field, 'options' => 
						array_map(function($v) use ($value) {
							if($v['value'] == $value)
								$v['selected']	=	true;
							return $v;
						}, $inputs[$field]['options'])
					, 'class' => 'nbr']);
					break;
				default:
					echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);

			}
		}
		else
			echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
		?>

		</div>
        <?php $cfield   =   ob_get_contents();
        ob_end_clean();
        
        $f[$field]  =   $cfield;
        
        endforeach ?>
    
    
    <?php echo $f['ID'] ?>
    <?php echo $f['unique_id'] ?>


    <script>
        $(function(){
            var userphoto   =   $('.photo');
            userphoto.height(userphoto.width());
            $(window).on('resize', function(){
                userphoto.height(userphoto.width());
            });
        });
    </script>
    
    <h2 style="font-weight: normal; margin-top: 0;">User Profile</h2>
    <p class="legal">Record ID: <?php echo $user['ID'] ?></p>
    <section class="profile about-me col-count-3 gapped col-c1-lg">
        
        <div style="background-color: #FFF; padding: 1em;">
            <div class="photo align-middle" style="width: 100%; overflow: hidden; background-image:url('/core/template/default/media/images/ui/transparent-grid.gif'); display: inline-block; border: 1px solid #CCC; background-size: 20px;">
                <?php if($user['file']): ?>
                <img src="<?php echo $user['file'] ?>" alt="User profile" />
                <?php endif ?>
            </div>
            
            <?php echo $f['file'] ?>
            <div style="display: none;">
                <?php echo $f['file_path'] ?>
                <?php echo $f['file_name'] ?>
            </div>
        </div>
        
        <div class="contact span2 span1-lg">
            <div style="padding: 1em; background-color: #FFF;">
                <h3 style="font-weight: normal; color: #CCC; margin-top: 0; text-transform: uppercase;">Personal Info</h3>

                <div class="col-count-2 gapped col-c1-lg">
                    <?php echo $setRequired($f['first_name']) ?>
                    <?php echo $setRequired($f['last_name']) ?>
                </div>
                <?php echo $setRequired($f['email']) ?>
                <div class="col-count-2 gapped col-c1-lg">
                    <?php echo $f['address_1'] ?>
                    <?php echo $f['address_2'] ?>
                    <?php echo $setRequired($f['city']) ?>
                    <?php echo $f['state'] ?>

                    <label class="required">Country
                        <select name="country" class="nbr" required>
                            <?php foreach($this->getHelper('Locale\Controller')->getLocaleData(2)->getData() as $abbr => $cinfo): ?>
                            <option value="<?php echo $abbr ?>"<?php if(!empty($user['country']) && $user['country'] == $abbr) echo ' selected="selected"'; elseif($abbr == 'US') echo ' selected="selected"' ?>><?php echo $cinfo['title'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>


                    <?php echo $f['postal'] ?>

                </div>
            </div>
                
            <div style="padding: 1em; margin-top: 1em; background-color: #FFF;">
                <h3 style="font-weight: normal; color: #CCC; margin-top: 0; text-transform: uppercase;">Account</h3>
                <p class="small">If updating the profile, leave password blank to leave it as is. New accounts require the password to be filled.</p>
                <div class="col-count-2 gapped col-c1-lg">
                    <?php echo $setRequired($f['username']) ?>
                    <?php echo $f['password'] ?>
                </div>
            </div>
        </div>
        
    </section>

    <section style="padding: 1em; background-color: #FFF; margin-top: 1em;">
        <div class="table-row col-count-3 gapped lrg-2 med-1">
            <div>
                <h3 style="font-weight: normal; color: #CCC; margin-top: 0; text-transform: uppercase;">Permissions</h3>
                <?php echo $f['usergroup'] ?>
                <?php echo $f['user_status'] ?>
            </div>
            
            <div>
                <h3 style="font-weight: normal; color: #CCC; margin-top: 0; text-transform: uppercase;">Access</h3>
                <?php echo ($f['attempts'])?? 'Attempts not set.' ?>
                <?php echo ($f['last_attempt'])?? 'Attempts not set.' ?>
            </div>
            
            <div class="last-col">
                <?php if(empty($this->getRequest('create'))): ?>
                <div><?php echo $Form->checkbox(['label' => 'Mark for deletion?','name'=>'delete', 'value'=>'on', 'class' => 'nbr']) ?></div>
                <?php endif ?>
                
                <?php echo $Form->submit(['name'=>'','value'=>'SAVE', 'class' => 'nbr button green token_button', 'disabled'=>'disabled', 'other'=> ['data-token="nProcessor"']]) ?>
            </div>
        </div>
    </section>
    
<?php echo $Form->close() ?>
</div>