<?php

class Zwe_Calendar_Day extends Zend_Date
{
    /**
     * @param string|integer|Zend_Date|array $date
     * @param string $part
     * @param string|Zend_Locale $locale
     */
    public function __construct($date = null, $part = null, $locale = null)
    {
        parent::__construct($date, $part, $locale);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->get(Zend_Date::DAY_SHORT);
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return array();
    }
}

?>