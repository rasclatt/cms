<?php 
use \Nubersoft\ {
    nForm as Form,
    nReflect
};
?>
<div class="section-head nTrigger arrow-down white" data-instructions='{"FX":{"fx":["slideUp","accordian"],"event":["click","click"],"acton":[".section","next::slideToggle"],"fxspeed":["fast","fast"]}}'>Country/Language</div>
<div class="section hide show">

    <?php $Locale = nReflect::instantiate('\Nubersoft\Localization\Controller') ?>

    <h3>Localization Settings</h3>
    <?php echo Form::getOpen(['action' => $this->getAdminPage()."?loadpage=load_settings_page&subaction=global&section=general", "enctype" => "multipart/form-data"]) ?>
        <?php echo Form::getFullhide(['name' => 'action', 'value' => 'locale_attributes']) ?>
    
        <div class="margin-top-1 margin-bottom-1">
            <p>Upload a country CSV</p>
            <input type="file" name="countries" class="nbr auto-width" />
            <?php echo Form::getSubmit(['value' => 'SAVE', 'class' => 'medi-btn dark settings margin-bottom-0']) ?>
        </div>
    
        <div class="margin-bottom-2">
            <a href="#" class="canceller button standard green rounded locale-edit" data-addattr="country">Add Country</a>
            <a href="#" class="canceller button standard green rounded locale-edit" data-addattr="language">Add Language</a>
        </div>
        <h5>Countries</h5>
        <p>The default is US. If you are adding countries besides US then you need to add US if you intend to use it.</a>
        <div id="edit-country-dropper" class="col-count-3 gapped-2">
            <?php foreach($Locale->getActiveCountries() as $langAttr): ?>

            <div class="col-count- gapped-half locale-item" style="grid-template: 1fr / 100px 100px 1fr;">
                <div>
                    <label>
                        <input type="text" name="country[name][]" value="<?php echo strtoupper($langAttr['option_attribute']) ?>" class="nbr" placeholder="Create a country" />
                    </label>
                </div>
                <div>
                    <label>
                        <input type="text" name="country[page_order][]" value="<?php echo $langAttr['page_order'] ?>" placeholder="Order" class="nbr auto-width" />
                    </label>
                </div>
                <div class="flexor">
                    <label>
                        <select name="country[page_live][]" class="nbr auto-width">
                            <option value="off" <?php if($langAttr['page_live'] == 'off') echo 'selected="selected"' ?>>Off</option>
                            <option value="on" <?php if($langAttr['page_live'] == 'on') echo 'selected="selected"' ?>>On</option>
                            <option value="adm" <?php if($langAttr['page_live'] == 'adm') echo 'selected="selected"' ?>>Admin Only</option>
                        </select>
                    </label>
                    <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
                </div>
            </div>

            <?php endforeach ?>
        </div>

        <h5 class="margin-top-2">Languages</h5>
        <p>The default is EN. If you are adding languages besides EN then you need to add EN if you intend to use it.</a>
        <div id="edit-language-dropper" class="col-count-3 gapped-2">
            <?php foreach($Locale->getActiveLanguages() as $langAttr): ?>

            <div class="col-count- gapped-half locale-item" style="grid-template: 1fr / 100px 100px 1fr;">
                <div>
                    <label>
                        <input type="text" name="language[name][]" value="<?php echo strtoupper($langAttr['option_attribute']) ?>" class="nbr" placeholder="Create a language" />
                    </label>
                </div>
                <div>
                    <label>
                        <input type="text" name="language[page_order][]" value="<?php echo $langAttr['page_order'] ?>" placeholder="Order" class="nbr auto-width" />
                    </label>
                </div>
                <div class="flexor">
                    <label>
                        <select name="language[page_live][]" class="nbr auto-width">
                            <option value="off" <?php if($langAttr['page_live'] == 'off') echo 'selected="selected"' ?>>Off</option>
                            <option value="on" <?php if($langAttr['page_live'] == 'on') echo 'selected="selected"' ?>>On</option>
                            <option value="adm" <?php if($langAttr['page_live'] == 'adm') echo 'selected="selected"' ?>>Admin Only</option>
                        </select>
                    </label>
                    <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
                </div>
            </div>

            <?php endforeach ?>
        </div>

        <div style="align-self: end;"><?php echo Form::getSubmit(['value' => 'SAVE', 'class' => 'medi-btn dark settings margin-bottom-0']) ?></div>
    <?php echo Form::getClose() ?>

    <script>
    $(function(){
        $('.locale-edit').on('click', function(){
            let thisAttr =   $(this).data('addattr');
            $(`#edit-${thisAttr}-dropper`).append(`
    <div class="col-count- gapped-half locale-item" style="grid-template: 1fr / 100px 100px 1fr;">
        <div>
            <label>
                <input type="text" name="${thisAttr}[name][]" value="" class="nbr" placeholder="Create a ${thisAttr}" />
            </label>
        </div>
        <div>
            <label>
                <input type="text" name="${thisAttr}[page_order][]" value="1" placeholder="Order" class="nbr auto-width" />
            </label>
        </div>
        <div class="flexor">
            <label>
                <select name="${thisAttr}[page_live][]" class="nbr auto-width">
                    <option value="off">Off</option>
                    <option value="on">On</option>
                    <option value="admin">Admin Only</option>
                </select>
            </label>
            <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
        </div>
    </div>`);
        });
        
        $('#admin-content').on('click', '.locale-delete-item', function(){
            $(this).parents('.locale-item').replaceWith('');
        });
    });
    </script>
</div>