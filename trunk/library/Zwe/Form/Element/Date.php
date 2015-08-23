<?php

class Zwe_Form_Element_Date extends Zend_Form_Element_Xhtml
{
    /**
     * @var string
     */
    protected $_dateFormat = '%year%-%month%-%day%';

    /**
     * @var int
     */
    protected $_year = null;
    /**
     * @var int
     */
    protected $_month = null;
    /**
     * @var int
     */
    protected $_day = null;

    protected $_validators = array(array('validator' => 'Date', 'options' => array('format' => 'YYYY-mm-dd')));

    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath('Zwe_Form_Decorator', 'Zwe/Form/Decorator', 'decorator');

        parent::__construct($spec, $options);
    }

    public function loadDefaultDecorators()
    {
        if($this->loadDefaultDecoratorsIsDisabled())
            return;

        $decorators = $this->getDecorators();
        if(empty($decorators))
            $this->addDecorator('Date')
                 ->addDecorator('Errors')
                 ->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
                 ->addDecorator('HtmlTag', array('tag' => 'dd', 'id' => $this->getName() . '-element'))
                 ->addDecorator('Label', array('tag' => 'dt'));
    }

    public function setDay($day)
    {
        $this->_day = (int) $day;
        return $this;
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function setMonth($month)
    {
        $this->_month = (int) $month;
        return $this;
    }

    public function getMonth()
    {
        return $this->_month;
    }

    public function setYear($year)
    {
        $this->_year = (int) $year;
        return $this;
    }

    public function getYear()
    {
        return $this->_year;
    }

    public function setValue($value)
    {
        if(is_int($value))
            $this->setDay(date('d', $value))
                 ->setMonth(date('m', $value))
                 ->setYear(date('Y', $value));
        elseif(is_string($value))
        {
            $date = strtotime($value);
            $this->setDay(date('d', $date))
                 ->setMonth(date('m', $date))
                 ->setYear(date('Y', $date));
        }
        elseif(is_array($value) && isset($value['day']) && isset($value['month']) && isset($value['year']))
            $this->setDay($value['day'])
                 ->setMonth($value['month'])
                 ->setYear($value['year']);
        elseif(!isset($value))
            $this->setDay(date('d'))
                 ->setMonth(date('m'))
                 ->setYear((date('Y')));
        else
            throw new Exception('Invalid date value provided');

        return $this;
    }

    public function getValue()
    {
        return str_replace(array('%year%', '%month%', '%day%'), array($this->getYear(), str_pad($this->getMonth(), 2, 0, STR_PAD_LEFT), str_pad($this->getDay(), 2, 0, STR_PAD_LEFT)), $this->_dateFormat);
    }
}

?>