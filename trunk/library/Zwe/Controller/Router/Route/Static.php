<?php

/**
 * @file library/Zwe/Controller/Router/Route/Static.php
 * Il router delle news.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 * @version     $Id: Static.php 40 2011-07-23 11:31:49Z flicofloc@gmail.com $
 */

/**
 * Il router delle pagine statiche.
 * Imposta il routing delle pagine statiche.
 *
 * @uses        Zwe_Controller_Router_Route
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 */

class Zwe_Controller_Router_Route_Static extends Zwe_Controller_Router_Route
{
    protected function isMatching()
    {
        return $this->_page instanceof Zwe_Model_Page_Static;
    }

    public function assemble($data = array(), $reset = false, $encode = false)
    {

    }
}

?>