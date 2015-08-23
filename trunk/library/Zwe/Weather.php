<?php

class Zwe_Weather
{
    /**
     * @var Zwe_Weather_Weather
     */
    protected $_weather = null;
    /**
     * @var Zwe_Weather_Forecast
     */
    protected $_forecast = null;

    /**
     * @var Zwe_Weather_Moon
     */
    protected $_moon = null;

    protected $_googleAddress = 'http://www.google.com/ig/api?hl=en&weather=';

    public function __construct($Location, $GetWeather = true, $GetForecast = true, $GetMoon = true)
    {
        $Url = $this->_googleAddress . trim(urlencode($Location));
        $Xml = new SimpleXMLElement($Url, null, true);

        if(!$Xml->weather->problem_cause)
        {
            if($GetWeather)
                $this->_weather = new Zwe_Weather_Weather($Xml);

            if($GetForecast)
                $this->_forecast = new Zwe_Weather_Forecast($Xml);

            if($GetMoon)
                $this->_moon = new Zwe_Weather_Moon();
        }
        else
            throw new Exception("XML retrieved is not valid. Please check that the city string is correct");
    }

    public function getWeather()
    {
        return $this->_weather;
    }

    public function getForecast()
    {
        return $this->_forecast;
    }

    public function getMoon()
    {
        return $this->_moon;
    }
}