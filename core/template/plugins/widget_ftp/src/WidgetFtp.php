<?php
namespace Widget;

use \Widget\Dto\WidgetFtp\DataResponse as Dto;
use \Nubersoft\nApp;

class WidgetFtp
{
    private $nApp, $data;
    /**
     *	@description	
     *	@param	
     */
    public function __construct(nApp $nApp)
    {
        $this->nApp = $nApp;
        $settings = $this->nApp->getDataNode('settings')['system'];
        $dto = new Dto();
        $allowed = array_keys($dto->toArray());
        
        foreach($settings as $r) {    
            if(!in_array($r['category_id'], $allowed))
                continue;
                
            $dto->{$r['category_id']} = $r['option_attribute'];
        }
        $this->data = $dto;
    }
    /**
     *	@description	
     *	@param	
     */
    public function getSettings(): Dto
    {
        return $this->data;
    }
}