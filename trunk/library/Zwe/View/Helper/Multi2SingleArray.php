<?php

class Zwe_View_Helper_Multi2SingleArray extends Zend_View_Helper_Abstract
{
    public function multi2SingleArray(array $Array, $Level = 0)
    {
        $Ret = array();

        foreach($Array as $Value)
        {
            $Child = $Value[$this->getChildKey()];
            unset($Value[$this->getChildKey()]);

            $Value[$this->getLevelKey()] = $Level;
            
            $Ret [] = $Value;
            if(isset($Child))
                $Ret = array_merge($Ret, $this->multi2SingleArray($Child, $Level + 1));
        }

        return $Ret;
    }

    protected function getChildKey()
    {
        return 'Child';
    }

    protected function getLevelKey()
    {
        return 'Level';
    }
}

?>