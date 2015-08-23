<?php

/**
 * @file library/Zwe/Controller/Router/Route/Calendar.php
 * Il router delle pagine col calendario.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 * @version     $Id: Static.php 40 2011-07-23 11:31:49Z flicofloc@gmail.com $
 */

/**
 * Il router delle pagine col calendario.
 * Imposta il routing delle pagine col calendario.
 *
 * @uses        Zwe_Controller_Router_Route
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 */

class Zwe_Controller_Router_Route_Calendar extends Zwe_Controller_Router_Route
{
    protected function isMatching()
    {
        return $this->_page instanceof Zwe_Model_Page_Calendar;
    }

    protected function getParameters()
    {
        $Parameters = parent::getParameters();
        $PageParameters = $this->_page->Parameters;

        if(empty($PageParameters))
            return $Parameters;

        # /^(?P<action>\w+)?\/?(?P<month>\d+)?\/?(?P<year>\d+)?/
    }

    public function assemble($data = array(), $reset = false, $encode = false)
    {

    }
}

?>