<?php
$media  =   $this->getPluginContent('table_data');
$inputs	=	$this->getHelper('Settings\Controller')->getFormAttr('components');
$Form	=	$this->getHelper('nForm');
echo $Form->open(['id'=>'media-editor','enctype'=>'multipart/form-data']);
echo $Form->fullhide(['name' => 'action', 'value' => 'edit_table_rows_details']);
echo $Form->fullhide(['name' => 'token[nProcessor]', 'value' => '']);
echo $Form->fullhide(['name' => 'table', 'value' => 'components']);

$fields =   [];
foreach($media as $field => $value):
	if(in_array($field, ['ID','unique_id'])) {
		$inputs[$field]['column_type']	=	'fullhide';
	}

	$keyset	=	(!empty($inputs[$field]['column_type']));
        
		if(empty($value))
			$value	=	$this->getPost($field);
		
		$label	=	$this->colToTitle($field);

        if($field == 'content') {
            $fields[$field]  =   $Form->textarea([ 'name'=> $field, 'value' => $value, 'class' => 'nbr textarea', 'style' => 'min-height: 300px;']);
            continue;
        }

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

<div class="nbr_warning stay"><?php if($media['component_type'] == 'transkey'): ?>This is a translation key (Transkey). It is the base key that identify where translations go.<?php else: ?>This is a translation. It identified by combining the Transkey, country abbreviation, and the language abbreviation.<?php endif ?></div>

<?php if($media['component_type'] != 'transkey'): ?>

<div class="margin-top-2 margin-bottom-2">
    <table border="0" cellpadding="0" cellspacing="0" class="standard" style="width: auto;">
        <tr>
            <th>Transkey</th>
            <th>Country</th>
            <th>Language</th>
        </tr>
        <tr>
            <td><?php echo substr($media['title'], 0, -4) ?></td>
            <td><?php $c = substr($media['title'], -4, 2) ?><img src="/client/media/images/flag-en.jpeg" style="height: 1em; width: 1em; display: inline-block;" />&nbsp;<?php echo strtoupper($c) ?></td>
            <td><?php $l = substr($media['title'], -2, 2) ?><img src="/client/media/images/flag-<?php echo $l ?>.jpeg" style="height: 1em; width: 1em; display: inline-block;" />&nbsp;<?php echo strtoupper($l) ?></td>
        </tr>
    </table>
</div>

<?php endif ?>

<div class="pad-bottom-3 col-count-2 gapped med-1">
    <?php foreach($fields as $k => $row): ?>
        <?php if(preg_match('/^file|cached|page_order|group|admin|ref|parent|time|component/', $k)) continue; ?>
    <?php if($k == 'content') echo '<div class="span-2 push-col-1 medium">' ?>
        <?php echo $row ?>
    <?php if($k == 'content') echo '</div>' ?>

    <?php endforeach ?>
    <div class="align-bottom">
        <div class="align-middle"><input type="submit" class="button standard wb sml" value="SAVE" /></div>
    </div>
</div>
<style>
    * {
        box-sizing: border-box;
    }
    @media (max-width: 1038px) {
        .table-row-container-wrap {
            border: none;
            max-width: none;
            overflow: auto;
        }
    }
    table.standard tr > * {
        padding: 0.5em !important;
        font-size: 1em;
    }
</style>