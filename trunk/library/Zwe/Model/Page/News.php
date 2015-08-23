<?php

/**
 * @file library/Zwe/Model/Page/News.php
 * Il modello della pagina delle news.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_Page
 * @version     $Id: News.php 126 2011-08-03 16:20:17Z flicofloc@gmail.com $
 */

/**
 * Il modello della pagina delle news.
 * Oltre all'inizializzazione di base, carica anche le news della pagina.
 *
 * @uses        Zwe_Model_Page
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_Page
 */
class Zwe_Model_Page_News extends Zwe_Model_Page
{
    /**
     * L'array con tutte le news della pagina.
     *
     * @var array
     */
    protected $_news = array();

    public static function getNewsPages($Tree = false)
    {
        return self::getPagesByType('News', $Tree);
    }

    /**
     * Ricava le news dal database.
     */
    protected function specificPageInit()
    {
        $this->_news = Zwe_Model_News::getPageNews($this->IDPage);
    }

    public function __get($Name)
    {
        if('News' == $Name)
            return $this->_news;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('News' == $Name)
        {
            if(is_array($Value))
                $this->_news = $Value;
            else
                throw new Exception('$Value must be an array');
        }
        else
            parent::__set($Name, $Value);
    }
}

?>