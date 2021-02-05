<?php
use \Nubersoft\ {
    Localization,
    Localization\Controller as Locale,
    Locale as Countries
};
$Locale =   new Locale();
$Countries  =   (new Countries())->get(false, 2); 
$abbrevs    =   $Locale->getActiveCountries(true);
if(count($abbrevs) <= 1)
    return false;
?>
<div class="align-middle pad-left-1 pad-right-1">
    <div class="check-box language-menu">
       <label class="check-topbox" for="lang-<?php echo $rand = rand() ?>"><?php echo $sclang = Localization::getSiteCountry() ?>&nbsp;<i class="fas fa-chevron-down m-change"></i></label>
        <input type="checkbox" name="lang" id="lang-<?php echo $rand ?>" class="lang-clicker" value="<?php echo $sclang ?>" />

        <div class="lang-menu">

            <?php foreach($abbrevs as $row):
                if($row['active'] == 'off')
                    continue;
                elseif($row['active'] == 'adm') {
                    if(!$this->isAdmin())
                        continue;
                }
                elseif(empty($Countries[strtoupper($row['abbr'])])) {
                    if($this->isAdmin()) {
                        $str    =   strtoupper($row['abbr']);
                        throw new \Exception("Country {$str} doesn't exist", 500);
                    }
                    continue;
                }
            ?>

             <label<?php if($checked = ($sclang == $row['abbr'])): ?> class="active" <?php endif ?>>
                <?php echo $Countries[strtoupper($row['abbr'])]['title'] ?><input class="locale-option" type="radio" name="country" value="<?php echo $row['abbr'] ?>" <?php if($checked): ?> checked="checked" <?php endif ?> />
            </label>

            <?php endforeach ?>
        </div>
    </div>
</div>