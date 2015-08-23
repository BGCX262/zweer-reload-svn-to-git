<?php

class Admin_View_Helper_GetPageSelect extends Zwe_View_Helper_Multi2SingleArray
{
    public function getPageSelect(array $Tree)
    {
        $Tree = $this->multi2SingleArray($Tree);
        $Ret = array();

        foreach($Tree as $Page)
        {
            $Ret[] = array('key' => $Page['IDPage'], 'value' => str_repeat('-', $Page['Level'] + 1) . ' ' . $Page['Title']);
        }

        return $Ret;
    }
}

?>