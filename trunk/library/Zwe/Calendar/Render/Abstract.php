<?php

abstract class Zwe_Calendar_Render_Abstract extends Zwe_Option
{
    /**
     * @var Zwe_Calendar
     */
    protected $_calendar = null;

    public function __construct(Zwe_Calendar $calendar, array $options = array())
    {
        $this->setCalendar($calendar);
        $this->setOptions($options);

        $this->init();
    }

    public function init()
    {

    }

    public function getCalendar()
    {
        return $this->_calendar;
    }

    public function setCalendar(Zwe_Calendar $calendar)
    {
        $this->_calendar = $calendar;
        return $this;
    }
}

?>