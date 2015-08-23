<?php

class Zwe_Form_Decorator_Date extends Zend_Form_Decorator_Abstract
{
    protected $_days = array(1 => 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31);
    protected $_month = null;
    protected $_year = null;

    public function render($content)
    {
        $element = $this->getElement();
        if(!$element instanceof Zwe_Form_Element_Date)
            return $content;

        $view = $element->getView();
        if(!$view instanceof Zend_View_Interface)
            return $content;

        $day = $element->getDay();
        $month = $element->getMonth();
        $year = $element->getYear();
        $name = $element->getFullyQualifiedName();

        $date  = $view->formSelect($name . '[day]', $day, null, $this->getDays()) . ' ';
        $date .= $view->formSelect($name . '[month]', $month, null, $this->getMonths()) . ' ';
        $date .= $view->formSelect($name . '[year]', $year, null, $this->getYears());

        switch($this->getPlacement())
        {
            case self::PREPEND:
                return $date . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $date;
        }
    }

    protected function getDays()
    {
        return $this->_days;
    }

    protected function getMonths()
    {
        if(!isset($this->_month))
            $this->_month = Zend_Locale::getTranslationList('month');

        return $this->_month;
    }

    protected function getYears()
    {
        if(!isset($this->_year))
        {
            foreach(range(date('Y'), 1900) as $year)
                $this->_year[$year] = $year;
        }

        return $this->_year;
    }
}

?>