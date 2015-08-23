<?php

class Admin_View_Helper_GetPhotoCheckbox extends Zend_View_Helper_Abstract
{
    public function getPhotoCheckbox(array $Photos)
    {
        $Ret = array();

        foreach($Photos as $Photo)
        {
            $Ret[] = array('key' => $Photo['IDPhoto'], 'value' => $Photo['Title']);
        }

        return $Ret;
    }
}

?>