<?php

class Zwe_Calendar extends Zwe_Option
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    /**
     * Le opzioni di base.
     * @var array
     */
    protected $_defaultOptions = array('startOfWeek' => self::SUNDAY,
                                       'autoCaching' => true);

    /**
     * Il giorno da cui parte la costruzione del calendario.
     * @var Zend_Date
     */
    protected $_date = null;
    /**
     * Contiene le settimane del mese da visualizzare sul calendario.
     * @var array
     */
    protected $_weeks = array();
    /**
     * Contiene i giorni.
     * E' un array multidimensionale. La prima dimensione è l'anno, la seconda il mese e infine il giorno.
     * @var array
     */
    protected $_days = array();

    /**
     * Contiene gli eventi.
     * Usa la stessa logica dei giorni, quindi un array multidimensionale.
     *
     * @todo Ancora da implementare tutto.
     *
     * @var array
     */
    protected $_events = array();

    /**
     * I nomi dei giorni secondo la codifica locale.
     * @var array
     */
    protected $_dayNames = null;
    /**
     * I nomi dei mesi secondo la codifica locale.
     * @var array
     */
    protected $_monthNames = null;

    /**
     * Contiene l'oggetto della richiesta
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request = null;

    /**
     * Il costruttore del calendario.
     * Istanzia $_request, imposta le opzioni, il timestamp e infine assegna la data.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();

        $this->setOptions($options);

        $this->_setTimestamp();
        $this->setDate($this->_options['timestamp']);

        $this->_setCache();

        $this->_generateWeeks();
        $this->init();
    }

    /**
     * Imposta il timestamp.
     * Se non è stato passato con le opzioni prende come base il timestamp attuale e quindi lo modifica in base alla richiesta.
     */
    protected function _setTimestamp()
    {
        if(!isset($this->_options['timestamp']))
        {
            $date = array('year' => (int) date('Y'),
                          'month' => (int) date('m'),
                          'day' => (int) date('d'),
                          'hour' => (int) date('h'),
                          'minute' => (int) date('i'),
                          'second' => (int) date('s'));

            if($this->_request->getParam('year'))
                $date['year'] = $this->_request->getParam('year');
            if($this->_request->getParam('month'))
                $date['month'] = $this->_request->getParam('month');
            if($this->_request->getParam('day'))
                $date['day'] = $this->_request->getParam('day');
            if($this->_request->getParam('hour'))
                $date['hour'] = $this->_request->getParam('hour');
            if($this->_request->getParam('minute'))
                $date['minute'] = $this->_request->getParam('minute');
            if($this->_request->getParam('second'))
                $date['second'] = $this->_request->getParam('second');

            $date = array_merge($date, isset($this->_options['date']) ? $this->_options['date'] : array());
            unset($this->_options['date']);

            $this->_options['timestamp'] = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        }
    }

    /**
     * Inizializza il giorno da cui partirà la costruzione del calendario.
     *
     * @param string|integer|Zend_Date|array $date
     * @param string $part
     * @param string|Zend_Locale $locale
     * @return Zwe_Calendar
     */
    public function setDate($date = null, $part = null, $locale = null)
    {
        $this->_date = new Zend_Date($date, $part, $locale);
        return $this;
    }

    /**
     * Inizializza la cache per rendere più veloci le operazioni sulle date.
     *
     * @throws Zend_Exception
     */
    protected function _setCache()
    {
        $cache = null;

        if(isset($this->_options['autoCache']) && extension_loaded('apc'))
            $cache = Zend_Cache::factory('Core', 'apc');
        elseif(isset($this->_options['cache']))
            $cache = $this->_options['cache'];
        elseif(Zend_Registry::isRegistered('Zwe_Calendar_Cache'))
            $cache = Zend_Registry::get('Zwe_Calendar_Cache');

        if(isset($cache))
        {
            if(!$cache instanceof Zend_Cache_Core)
                throw new Zend_Exception('Instance of Zend_Cache_Core expected');

            $this->_date->setOptions(array('cache' => $cache));
        }
    }

    /**
     * Genera le settimane del calendario.
     *
     * @todo Sono giuste? O ne crea una in più se il mese finisce di sabato?
     */
    protected function _generateWeeks()
    {
        $Month = $this->_date->get(Zend_Date::MONTH);
        $Year = $this->_date->get(Zend_Date::YEAR);

        $DaysInMonth = $this->_date->get(Zend_Date::MONTH_DAYS);
        $FirstDay = date('w', mktime(0, 0, 0, $Month, 1, $Year));

        $DaysInPrevMonth = date('t', mktime(0, 0, 0, $Month - 1, 1, $Year));

        for($I = 0; $I < $FirstDay; ++$I)
            $this->_weeks[0][$I] = $this->getDay($DaysInPrevMonth + $I - $FirstDay + 1, $Month - 1);

        for($I = 1, $J = $FirstDay, $W = 0; $I <= $DaysInMonth; ++$I)
        {
            $this->_weeks[$W][$J++] = $this->getDay($I);

            if(7 == $J)
            {
                $J = 0;
                $W++;
            }
        }

        for($I = $J; $I < 7 && $J != 0; ++$I)
            $this->_weeks[$W][$I] = $this->getDay($I - $J + 1, $Month + 1);
    }

    /**
     * Ritorna il giorno selezionato.
     * Se il giorno non esiste lo crea.
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @return Zwe_Calendar_Day
     */
    public function getDay($day, $month = null, $year = null)
    {
        if(!isset($month))
            $month = $this->_date->get(Zend_Date::MONTH);

        if(!isset($year))
            $year = $this->_date->get(Zend_Date::YEAR);

        $day = (int) $day;
        $month = (int) $month;
        $year = (int) $year;

        if(!isset($this->_days[$year][$month][$day]))
            $this->setDay(mktime(0, 0, 0, $month, $day, $year));

        return $this->_days[$year][$month][$day];
    }

    /**
     * Memorizza il giorno selezionato dopo averlo generato.
     *
     * @param string|integer|Zend_Date|array $date
     * @param string $part
     * @param string|Zend_Locale $locale
     * @return Zwe_Calendar
     */
    public function setDay($date, $part = null, $locale = null)
    {
        $day = new Zwe_Calendar_Day($date, $part, $locale);
        $this->_days[(int) $day->get(Zend_Date::YEAR)][(int) $day->get(Zend_Date::MONTH_SHORT)][(int) $day->get(Zend_Date::DAY_SHORT)] = $day;

        return $this;
    }

    /**
     * Dove avvengono le ulteriori inizializzazioni.
     * Viene usato per compatibilità visto che a un futuro figlio potrebbe interessare questo spazio.
     */
    public function init()
    {

    }

    /**
     * Stampa il calendario.
     * Redireziona su {@link render()}
     *
     * @return string
     */
    public function __toString()
    {
        try
        {
            return $this->_render();
        }
        catch(Exception $E)
        {
            trigger_error($E->getMessage(), E_USER_WARNING);
        }

        return '';
    }

    /**
     * Renderizza il calendario in HTML.
     *
     * @return string
     */
    protected function _render()
    {
        return Zwe_Calendar_Render::factory($this, $this->_options)->render();
    }

    /**
     * Ritorna i nomi dei giorni della settimana.
     * Se non sono ancora stati generati li genera.
     *
     * @param array $format
     * @return array
     */
    public function getDayNames(array $format = array())
    {
        if(!isset($this->_dayNames))
        {
            $dayNames = Zend_Locale::getTranslationList('day', $this->_date->getLocale(), $format);

            $start = $this->_options['startOfWeek'];
            while($start--)
            {
                $tmp = array_shift($dayNames);
                $dayNames[] = $tmp;
            }

            $this->_dayNames = $dayNames;
        }

        return $this->_dayNames;
    }

    /**
     * Ritorna i nomi dei mesi.
     * Se non sono ancora stati generati li genera.
     *
     * @param array $format
     * @return array
     */
    public function getMonthNames(array $format = array())
    {
        if(!isset($this->_monthNames))
        {
            $monthNames = Zend_Locale::getTranslationList('month', $this->_date->getLocale(), $format);

            foreach($monthNames as $monthName)
                $this->_monthNames[] = $monthName;
        }

        return $this->_monthNames;
    }

    /**
     * Wrapper per _date->get()
     *
     * @param string $part
     * @param string|Zend_Locale $locale
     * @return string
     */
    public function get($part = null, $locale = null)
    {
        return $this->_date->get($part, $locale);
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->_days;
    }

    /**
     * @param int $week
     * @return array
     */
    public function getWeek($week)
    {
        return $this->_weeks[$week - 1];
    }

    /**
     * @return array
     */
    public function getWeeks()
    {
        return $this->_weeks;
    }

    /**
     * @return Zend_Date
     */
    public function getDate()
    {
        return $this->_date;
    }
}

?>