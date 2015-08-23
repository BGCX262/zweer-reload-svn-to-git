<?php

/**
 * @file library/Zwe/Controller/Router/Route/News.php
 * Il router delle news.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 * @version     $Id: News.php 88 2011-07-29 08:24:30Z flicofloc@gmail.com $
 */

/**
 * Il router delle news.
 * Imposta il routing delle pagine delle news.
 *
 * @uses        Zwe_Controller_Router_Route
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 */
class Zwe_Controller_Router_Route_News extends Zwe_Controller_Router_Route
{
    /**
     * Verifica che la pagina sia una news.
     * Se è così, controlla se ci sono i parametri per il permalink o per il numero di pagina.
     * Se non ci sono, assegna l'azione passata.
     *
     * @param string $path L'uri della pagina.
     * @return array|bool I parametri della pagina o, nel caso non sia una pagina news, false
     */
    public function match($path)
    {
        $defaults = parent::match($path);
        if(false === $defaults)
            return false;
        
        $return = array();

        $params = $this->_page->Parameters;

        if('show' == $params[0] && isset($params[1]))
        {
            $return['action'] = 'permalink';
            $return['news'] = $params[1];
            $this->_page->shiftParameters();
            $params = $this->_page->shiftParameters();
        }
        elseif(is_numeric($params[0]))
        {
            $return['page'] = (int) $params[0];
            $params = $this->_page->shiftParameters();
        }
        elseif(isset($params[0]))
        {
            $return['action'] = $params[0];
            $params = $this->_page->shiftParameters();
        }
        
        return $return + $defaults;
    }

    protected function isMatching()
    {
        return $this->_page instanceof Zwe_Model_Page_News;
    }

    public function assemble($data = array(), $reset = false, $encode = false)
    {

    }
}

?>