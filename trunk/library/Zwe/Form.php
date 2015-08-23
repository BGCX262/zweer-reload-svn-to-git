<?php

class Zwe_Form extends Zend_Form
{
    public function __construct($options = null)
    {
        $this->addPrefixPath("Zwe_Form", "Zwe/Form/");

        parent::__construct($options);
    }
}

?>