<?php

class Zwe_Weather_Weather extends Zwe_Weather_Day
{
    public function __construct(SimpleXMLElement $Xml)
    {
        parent::__construct($Xml->weather->current_conditions);
    }
}