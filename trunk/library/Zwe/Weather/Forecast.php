<?php

class Zwe_Weather_Forecast implements Iterator
{
    private $_position = 0;
    private $_days = array();

    public function __construct($Xml)
    {
        foreach($Xml->weather->forecast_conditions as $ForecastConditions)
        {
            $this->_days[] = new Zwe_Weather_Day($ForecastConditions);
        }
    }

    public function current()
    {
        return $this->_days[$this->_position];
    }

    public function next()
    {
        ++$this->_position;
    }

    public function key()
    {
        return $this->_position;
    }

    public function valid()
    {
        return isset($this->_days[$this->_position]);
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function __toString()
    {
        return Zwe_Render::factory($this, array('viewScript' => 'weather/forecasts.phtml', 'scriptPath' => 'views/scripts/weather'))->render();
    }
}