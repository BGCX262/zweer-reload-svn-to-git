<?php

class Zwe_View_Helper_Js extends Zend_View_Helper_Abstract
{
    public function js($script)
    {
        return '<script type="text/javascript">' . "\n" . $script . "\n" . '</script>';
    }
}

?>