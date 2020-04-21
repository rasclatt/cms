<?php
$inputs	=	$this->getHelper('Settings\Controller')->getFormAttr('components');
echo $Form->open(['id'=>'user-editor'.$compData['ID'], 'class' => 'component-editor-form user-editor', 'enctype'=>'multipart/form-data', 'other' => "data-instructions='{\"action\":\"edit_component\"}'"]);
echo $Form->fullhide(['name' => 'action', 'value' => 'edit_component']);
echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => $this->getHelper('nToken')->setToken($token)->getToken($token, false)]);

foreach($compData as $field => $value):
    if(in_array($field, ['ID','unique_id'])) {
        $inputs[$field]['column_type']	=	'fullhide';
    }
    # Ignore this one
    if($field == 'ref_anchor')
        continue;

    if($field == 'file_size'): ?>

    <div style="margin-top: 1em; font-size: 0.85em; color: blue;"><?php echo round($this->getHelper('Conversion\Data')->getByteSize($value, ['from' => 'b', 'to' => 'mb']),2) ?>MB<br /></div>

        <?php continue ?>
    <?php endif ?>

    <?php $keyset	=	(!empty($inputs[$field]['column_type'])) ?>

    <div<?php if($keyset && $inputs[$field]['column_type'] == 'fullhide'): ?> style="display: none;"<?php endif ?>>

        <?php
        if(empty($value))
            $value	=	$this->getPost($field);

        $label	=	$this->colToTitle($field);

        if($field == 'category_id') {
            $value	=	(!empty($value))? $value : 'nbr_layout';
            if(!isset($inputs[$field]))
                $inputs[$field]	=	[];

            $inputs[$field]['column_type'] = 'fullhide';
        }

        if($field == 'page_order') {

            for($i = 1; $i <= 50; $i++) {
                $counter[$i]['name']	=
                $counter[$i]['value']	=	$i;
            }

            echo $Form->select(['label' => 'Component Order', 'name'=> $field, 'options' => 
                array_map(function($v) use ($value) {
                    if($v['value'] == $value)
                        $v['selected']	=	true;
                    return $v;
                }, $counter)
            , 'class' => 'nbr']);
        }
        elseif($field == 'parent_id') {

            $rows	=	$this->query("SELECT `title`, `content`, `unique_id` FROM components WHERE `component_type` = 'container' OR `component_type` = 'div' AND `ref_page` = ? AND `ID` != ?",[$ref_page, $compData['ID']])->getResults();

            if(empty($rows)) {
                continue;
            }

            $rows	=	array_merge([['title'=>'Select', 'unique_id' => '']],$rows);
            $rows	=	array_map(function($v) use ($value) {
                $v	= [
                    'name' => $v['title'],
                    'value' => $v['unique_id']
                ];

                if($v['value'] == $value)
                    $v['selected']	=	true;

                return $v;
            },$rows);

            echo $Form->select(['label' => 'Parent Component', 'name'=> $field, 'options' => 
                array_map(function($v) use ($value) {
                    if($v['value'] == $value)
                        $v['selected']	=	true;
                    return $v;
                }, $rows)
            , 'class' => 'nbr']);
        }
        elseif(in_array($field, ['file_path','timestamp'])) {
            $meth	=	(!empty($value))? 'text' : 'fullhide';
            echo $Form->{$meth}(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr', 'other' =>['readonly="readonly"']]);
        }
        elseif($field == 'file_name' && !empty($value)) {
            echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
        }
        elseif(isset($inputs[$field])) {

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
                    if(!empty($compData['file_path'])) {

                        $imgTypes	=	[
                            'gif',
                            'jpeg',
                            'jpg',
                            'png',
                            'bmp'
                        ];

                        $isImg	=	(in_array(strtolower(pathinfo($compData['file_name'], PATHINFO_EXTENSION)), $imgTypes));

                        try {
                            $imageThumb	=	($isImg)? $this->getHelper('System\Controller')->getThumbnail($compData['file_path'], $compData['file_name']) : false;
                        }
                        catch (\Exception $e) {
                            $imageThumb	=	$e->getMessage();
                        }
                        catch (\Nubersoft\HttpException $e) {
                            $imageThumb	=	$e->getMessage();
                        }

                        echo $this->setPluginContent('image_tools', [
                            'thumb' => $imageThumb,
                            'table'=> 'components',
                            'ID' => $compData['ID'],
                            'file_path' => $compData['file_path'],
                            'file_name' => $compData['file_name']
                        ])->getPlugin('component', DS.'image_tools.php');
                    }
                    echo $Form->file(['name'=> $field, 'value' =>'', 'class' => 'nbr']);
                    break;
                case('select'):
                    
                    echo $Form->select(['label' => $label, 'name'=> $field, 'options' => 
                        array_map(function($v) use ($field, $value) {

                            if($field == 'usergroup')
                                $v['value']	=	(!empty($v['value']) && !is_numeric($v['value']))? constant($v['value']) : $v['value'];

                            if($v['value'] == $value)
                                $v['selected']	=	true;

                            $v['name']	=	ucfirst($v['name']);
                            return $v;
                        }, $inputs[$field]['options'])
                    , 'class' => 'nbr']);
                    break;
                case('textarea'):
                    if($field == 'content') {
                        echo '
                        <div class="align-middle">
                            <div class="col-count-2 gapped align-center">
                                <div>
                                    <a class="expander mini-btn dark" href="#" data-acton=".component-container">EXPAND</a>
                                </div>
                                <div>
                                    <a href="#" class="canceller  mini-btn green ajax-save">Update</a> 
                                </div>
                            </div>
                        </div>';
                    }
                    echo $Form->textarea(['name'=> $field, 'value' => $value, 'class' => 'nbr code component tabber']);
                    break;
                default:
                    echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);

            }
        }
        else{
            if($field == 'ref_page') {
                echo $Form->select(['label' => 'Web page to display on', 'name'=> $field, 'options' => 
                    array_map(function($v) use ($value) {
                        $a['name']	=	$v['menu_name'].' ('.(($v['page_live'] == 'off')? 'Off' : 'On').')';
                        $a['value']	=	$v['unique_id'];

                        if($a['value'] == $value)
                            $a['selected']	=	true;
                        return $a;
                    }, $this->query("SELECT `unique_id`, `menu_name`, `page_live` FROM main_menus")->getResults())
                , 'class' => 'nbr']);
            }
            else {
                echo $Form->text(['label' => $label, 'name'=> $field, 'value' => $value, 'class' => 'nbr']);
            }
        }
        ?>

    </div>

    <?php endforeach ?>

    <?php if(empty($this->getRequest('create'))): ?>

    <div>
        <?php echo $Form->checkbox(['label' => 'Delete?','name'=>'delete', 'value'=>'on', 'class' => 'nbr']) ?>
    </div>

    <?php endif ?>

    <div>
        <?php echo $Form->submit(['name'=>'','value'=>'save', 'class' => 'nbr button green']) ?>
    </div>

<?php echo $Form->close() ?>
