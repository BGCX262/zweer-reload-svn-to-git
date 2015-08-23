<?php

abstract class Zwe_Render_Abstract extends Zwe_Option
{
    protected $_object = null;

    public function __construct($object, array $options = array())
    {
        $this->setObject($object);
        $this->setOptions($options);

        $this->init();
    }

    public function init()
    {

    }
    
    public function getObject()
    {
        return $this->_object;
    }

    public function setObject($object)
    {
        $this->_object = $object;

        return $this;
    }
}