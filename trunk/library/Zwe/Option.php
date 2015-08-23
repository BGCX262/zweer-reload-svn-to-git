<?php

abstract class Zwe_Option
{
    /**
     * @var array
     */
    protected $_options = array();
    /**
     * @var array
     */
    protected $_defaultOptions = array();

    /**
     * @param array $options
     * @return Zwe_Option
     */
    public function setOptions(array $options = array())
    {
        foreach($this->_defaultOptions as $key => $value)
            if(!isset($options[$key]))
                $options[$key] = $value;

        $this->_options = $options;
        return $this;
    }

    public function setOption($name, $value)
    {
        $this->_options[$name] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->_options[$name];
    }
}

?>