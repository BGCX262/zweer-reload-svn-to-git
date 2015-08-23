<?php

class Zwe_View_Helper_GetTextPreview extends Zend_View_Helper_Abstract
{
    public function getTextPreview($Text, $Length = 50)
    {
        $Text = strip_tags($Text);
        $TextLength = strlen($Text);
        $Diff = $TextLength - $Length;

        if($Diff > 0)
            return substr($Text, 0, $Length) . '...';
        else
            return $Text;
    }
}

?>