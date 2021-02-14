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
        <div id="edit-country-dropper" class="col-count-3 gapped-2 col-c1-lg">
            <?php foreach($Locale->getActiveCountries() as $langAttr): ?>

            <table class="locale-item">
                <tr>
                    <td>
                        <input type="text" name="country[name][]" value="<?php echo strtoupper($langAttr['option_attribute']) ?>" class="nbr width-all" placeholder="Create a country" />
                    </td>
                    <td>
                        <input type="text" name="country[page_order][]" value="<?php echo $langAttr['page_order'] ?>" placeholder="Order" class="nbr width-all" />
                    </td>
                    <td class="flexor">
                        <label>
                            <select name="country[page_live][]" class="nbr auto-all">
                                <option value="off" <?php if($langAttr['page_live'] == 'off') echo 'selected="selected"' ?>>Off</option>
                                <option value="on" <?php if($langAttr['page_live'] == 'on') echo 'selected="selected"' ?>>On</option>
                                <option value="adm" <?php if($langAttr['page_live'] == 'adm') echo 'selected="selected"' ?>>Admin Only</option>
                            </select>
                        </label>
                        <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
                    </td>
                </tr>
            </table>

            <?php endforeach ?>
        </div>

        <h5 class="margin-top-2">Languages</h5>
        <p>The default is EN. If you are adding languages besides EN then you need to add EN if you intend to use it.</a>
        <div id="edit-language-dropper" class="col-count-3 gapped-2 col-c1-lg">
            <?php foreach($Locale->getActiveLanguages() as $langAttr): ?>

            <table class="locale-item">
                <tr>
                    <td>
                        <input type="text" name="language[name][]" value="<?php echo strtoupper($langAttr['option_attribute']) ?>" class="nbr auto-all" placeholder="Create a language" />
                    </td>
                    <td>
                        <input type="text" name="language[page_order][]" value="<?php echo $langAttr['page_order'] ?>" placeholder="Order" class="nbr auto-all" />
                    </td>
                    <td class="flexor">
                        <label>
                            <select name="language[page_live][]" class="nbr auto-all">
                                <option value="off" <?php if($langAttr['page_live'] == 'off') echo 'selected="selected"' ?>>Off</option>
                                <option value="on" <?php if($langAttr['page_live'] == 'on') echo 'selected="selected"' ?>>On</option>
                                <option value="adm" <?php if($langAttr['page_live'] == 'adm') echo 'selected="selected"' ?>>Admin Only</option>
                            </select>
                        </label>
                        <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
                    </td>
                
                </tr>
            </table>

            <?php endforeach ?>
        </div>

        <div style="align-self: end;"><?php echo Form::getSubmit(['value' => 'SAVE', 'class' => 'medi-btn dark settings margin-bottom-0']) ?></div>
    <?php echo Form::getClose() ?>

    <script>
    $(function(){
        $('.locale-edit').on('click', function(){
            let thisAttr =   $(this).data('addattr');
            $(`#edit-${thisAttr}-dropper`).append(`
    <table class="locale-item">
        <tr>
            <td>
                <input type="text" name="${thisAttr}[name][]" value="" class="nbr auto-all" placeholder="Create a ${thisAttr}" />
            </td>
            <td>
                <input type="text" name="${thisAttr}[page_order][]" value="1" placeholder="Order" class="nbr auto-all" />
            </td>
            <tdd class="flexor">
                <label>
                    <select name="${thisAttr}[page_live][]" class="nbr auto-all">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                        <option value="admin">Admin Only</option>
                    </select>
                </label>
                <div class="align-middle"><a href="#" class="locale-delete-item canceller"><i class="fas fa-trash-alt"></i></a></div>
            </td>
        </tr>
    </table>`);
        });
        
        $('#admin-content').on('click', '.locale-delete-item', function(){
            $(this).parents('.locale-item').replaceWith('');
        });
    });
    </script>

    <h3>Translation Whitelist</h3>
    <p>Add domain names to allow access to your translation engine.</p>
    <form action="#" id="transhosts-list" method="post">
        <input type="hidden" name="action" value="create_transhost" />
        
        <input type="text" name="option_attribute[]" placeholder="example.com" class="nbr" />
        <?php foreach($this->query("SELECT * FROM system_settings WHERE category_id = 'transhost'")->getResults() as $row): ?>

        <input type="text" name="option_attribute[]" value="<?php echo $row['option_attribute'] ?>" class="nbr" />
        <?php endforeach ?>

        <div id="translation-hosts"></div>
        
        <div style="align-self: end;"><?php echo Form::getSubmit(['value' => 'SAVE', 'class' => 'medi-btn dark settings margin-bottom-0']) ?></div>
    </form>

    <script>
        $(function(){
	       $('#transhosts-list').on('submit', function(){
               
           };
        });
    </script>
</div>