<?php
$media	=	$this->getDataNode("media_data");
$this->removeNode("media_data");
$inputs	=	$this->getHelper('Settings\Controller')->getFormAttr($this->getRequest('table'));
$Form	=	$this->getHelper('nForm');
echo $Form->open(['id'=>'media-editor','enctype'=>'multipart/form-data']);
echo $Form->fullhide(['name' => 'action', 'value' => 'edit_table_rows_details']);
echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);

$fields =   [];
foreach($media as $field => $value):
	if(in_array($field, ['ID','unique_id'])) {
		$inputs[$field]['column_type']	=	'fullhide';
	}

	$keyset	=	(!empty($inputs[$field]['column_type']));
        
		if(empty($value))
			$value	=	$this->getPost($field);
		
		$label	=	$this->colToTitle($field);
		if(isset($inputs[$field])) {
			switch($inputs[$field]['column_type']) {
				case('fullhide'):
					$fields[$field]  =   $Form->fullhide([ 'name'=> $field, 'value' => $value]);
					break;
				case('hidden'):
					$fields[$field]  =   $Form->hidden(['name'=> $field, 'value' => $value]);
					break;
				case('text'):
					$fields[$field]  =   $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
					break;
				case('password'):
					$fields[$field]  =   $Form->password(['label' => $label, 'name'=> $field, 'value' => '', 'class' => 'nbr']);
					break;
				case('file'):
					$fields[$field]  =   $Form->file(['name'=> $field, 'value' =>'', 'class' => 'nbr']);
					break;
				case('select'):
					$fields[$field]  =   $Form->select(['label' => $label, 'name'=> $field, 'options' => 
						array_map(function($v) use ($value) {
							if($v['value'] == $value)
								$v['selected']	=	true;
							return $v;
						}, $inputs[$field]['options'])
					, 'class' => 'nbr']);
					break;
				default:
					$fields[$field]  =   $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);

			}
		}
		else
			$fields[$field]  =   $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
    endforeach ?>
        
        <?php //echo printpre($fields) ?>
    <div class="col-count-2 gapped lrg-1">
        <div style="max-height: 500px; overflow: hidden; border: 1px solid #CCC; padding: 1em; background-image:  url('/core/template/default/media/images/ui/transparent-grid.gif'); background-size: 3%;">
            <a href="<?php echo $media['file_path'].$media['file_name'] ?>" target="_blank" class="pointer"><img src="<?php echo $media['file_path'].$media['file_name'] ?>" style="display: inline-block; width: 100%; height: auto;" /></a>
        </div>
        <div>
            <?php echo $fields['ID'] ?>
            <?php echo $fields['unique_id'] ?>
            <?php echo $fields['file'] ?>
            <?php echo $fields['file_path'] ?>
            <label style="margin-top: 1em;">
                File Name: <?php echo $fields['file_name'] ?>
            </label>
            <label style="margin-top: 1em;">Full Path:
                <?php echo $Form->text(['class' => 'nbr selector', 'value' => $media['file_path'].$media['file_name'], 'other' =>'onClick="this.select();"' ]) ?>
            </label>
            
            <label style="margin-top: 1em;">File Size:
                <?php echo \Nubersoft\Conversion\Data::getByteSize($media['file_size'],['from'=>'b','to' => 'mb','ext' => 1, 'round' => 2]) ?>
            </label>
            <?php echo $fields['usergroup'] ?>
            <?php echo $fields['username'] ?>
            <div style="display: none;">
            <?php echo $fields['file_size'] ?>
            <?php echo $fields['content'] ?>
            <?php echo $fields['terms_id'] ?>
            <?php echo $fields['login_view'] ?>
            <?php echo $fields['page_order'] ?>
            <?php echo $fields['page_live'] ?>
            </div>
            <?php if(empty($this->getRequest('create'))): ?>
            <div><?php echo $Form->checkbox(['label' => 'Delete?','name'=>'delete', 'value'=>'on', 'class' => 'nbr']) ?></div>
            <?php endif ?>
            <div class="pad-top-small"><?php echo $Form->submit(['name'=>'','value'=>'save', 'class' => 'button token_button', 'disabled'=>'disabled', 'other'=> ['data-token="nProcessor"']]) ?></div>
            </div>
        </div>
    </div>
        
	
<?php echo $Form->close() ?>