<?php

class Zwe_View_Helper_Js_Alert extends Zwe_View_Helper_Js
{
    public function js_Alert($text, array $options = array())
    {
        return $this->js("new MooDialog.Alert('" . $text . "', " . Zend_Json::encode($options) . ");");
    }
}

?>