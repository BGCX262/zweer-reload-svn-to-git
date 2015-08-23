<?php

class Zwe_Weather_Day
{
    const CARDINAL_N = 'N';
    const CARDINAL_NE = 'NE';
    const CARDINAL_E = 'E';
    const CARDINAL_SE = 'SE';
    const CARDINAL_S = 'S';
    const CARDINAL_SW = 'SW';
    const CARDINAL_W = 'W';
    const CARDINAL_NW = 'NW';

    const HUMIDITY_STRING = 'Humidity: ${1}%';
    const WIND_STRING = 'Wind: ${1} at ${2} mph';

    private $_condition = '';
    private $_temp = array('Min' => 0,
                           'Max' => 0);
    private $_icon = '';

    /**
     * @var null|string
     */
    private $_humidity = null;
    /**
     * @var null|string
     */
    private $_wind = null;

    /**
     * @var null|string
     */
    private $_day = null;

    /**
     * Is the current day or a forecast?
     *
     * @var bool
     */
    private $_current = false;

    public function __construct(SimpleXMLElement $Xml)
    {
        $this->_condition = $Xml->condition['data'];
        $this->_icon = $Xml->icon['data'];

        if($Xml->day_of_week)
        {
            $this->_current = false;
            $this->_temp['Min'] = $Xml->low['data'];
            $this->_temp['Max'] = $Xml->high['data'];
            $this->_day = $Xml->day_of_week['data'];
        }
        else
        {
            $this->_current = true;
            $this->_temp['Min'] = $Xml->temp_c['data'];
            $this->_temp['Max'] = $Xml->temp_f['data'];
            $this->_humidity = $Xml->humidity['data'];
            $this->_wind = $Xml->wind_condition['data'];
        }
    }

    public function __toString()
    {
        return Zwe_Render::factory($this, array('viewScript' => 'weather/' . ($this->_current ? 'current' : 'forecast') . '.phtml', 'scriptPath' => 'views/scripts/weather'))->render();
    }

    public function setCondition($condition)
    {
        $this->_condition = $condition;
    }

    public function getCondition()
    {
        return $this->_condition;
    }

    public function getConditionRaw()
    {
        return preg_replace('#/ig/images/weather/(.*).gif#i', '$1', $this->_icon);
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function getHumidity()
    {
        return $this->_humidity;
    }

    public function getIcon()
    {
        return 'http://www.google.com' . $this->_icon;
    }

    public function getTemp($key = null)
    {
        if(!isset($key) || !isset($this->_temp[$key]))
            return $this->_temp;
        else
            return $this->_temp[$key];
    }

    public function getWind()
    {
        return $this->_wind;
    }
}