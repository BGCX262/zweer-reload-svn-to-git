<?php

class Zwe_View_Helper_Js_Error extends Zwe_View_Helper_Js
{
    public function js_Error($text, array $options = array())
    {
        return $this->js("new MooDialog.Error(\"" . $text . "\", " . Zend_Json::encode($options) . ");");
    }
}

?>