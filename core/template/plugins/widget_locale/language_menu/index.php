<?php
use \Nubersoft\ {
    Localization,
    Localization\Controller as Locale
};
$Locale =   new Locale();
$abbrevs    =   $Locale->getActiveLanguages(true);
if(count($abbrevs) <= 1)
    return false;
?>
<div class="align-middle pad-left-1 pad-right-1">
    <div class="check-box language-menu country-menu">
       <label class="check-topbox" for="lang-<?php echo $rand = rand() ?>"><?php echo $sclang = Localization::getSiteLanguage() ?>&nbsp;<i class="fas fa-chevron-down m-change"></i></label>
        <input type="checkbox" name="lang" id="lang-<?php echo $rand ?>" class="lang-clicker" value="<?php echo $sclang ?>" />

        <div class="lang-menu">

            <?php foreach($abbrevs as $row):
                if($row['active'] == 'off')
                    continue;
                elseif($row['active'] == 'adm') {
                    if(!$this->isAdmin())
                        continue;
                }
            ?>

             <label<?php if($checked = ($sclang == $row['abbr'])): ?> class="active" <?php endif ?>>
                <?php echo $row['abbr'] ?><input class="locale-option" type="radio" name="language" value="<?php echo $row['abbr'] ?>" <?php if($checked): ?> checked="checked" <?php endif ?> />
            </label>

            <?php endforeach ?>
        </div>
    </div>
</div>