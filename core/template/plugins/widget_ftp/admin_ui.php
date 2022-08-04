<?php
if($this->getGet('action') == 'translate') {
    $Settings   =   $this->getHelper('Settings');
    foreach(['en','cn','es','jp','kr'] as $lang) {
        $Localization   =   new \Nubersoft\Localization('us', $lang);
        $files  =   simplexml_load_file(NBR_CLIENT_DIR.DS.'settings'.DS.'translations'.DS.'messages.'.$lang.'.xlf');
        foreach($this->toArray($files->file->body)['trans-unit'] as $row) {
            $transkey   =   $row['@attributes']['id'].'us'.$lang;
            
            if($Settings->componentExists(['title' => $transkey, 'category_id' => 'translator'])) {
                $this->nQuery()->query("UPDATE component SET `content` = ? WHERE title = ? AND category_id = 'translator'", [
                    $row['target'],
                    $transkey 
                ]);
            }
            else {
                $Settings->addComponent([
                    'title' => $transkey,
                    'category_id' => 'translator',
                    'content' => $row['target']
                ]);
            }

            $Localization->saveTransKey($row['@attributes']['id'], $row['target'], 'bw', 1);
        }
    }
}



if(!preg_match('/\.local/',$this->getDataNode('routing_info')['host']))
    return false;

if($this->getGet('load') == basename(__DIR__)) {
    include(__DIR__.DS.'index.php');
    return false;
}
