<?php

/**
 * @file library/Zwe/View/Helper/Menu/Admin.php
 * Il menu per le pagine della parte admin.
 *
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 * @version     $Id: Admin.php 125 2011-08-03 10:28:57Z flicofloc@gmail.com $
 */

/**
 * Il menu per le pagine della parte admin.
 * Il menu è statico e recupera da un array le pagine cha andranno visualizzate.
 *
 * @uses        Zwe_View_Helper_Menu
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 * @todo        Rendere il menu dinamico in base ai permessi dell'utente
 */
class Zwe_View_Helper_Menu_Admin extends Zwe_View_Helper_Menu
{
    /**
     * Imposta i valori di default del menu.
     * Va a interrogare il database, ricercando quali sono le pagine figlie della root.
     */
    protected function setDefault()
    {
        $this->_default[] = array('Title' => 'Home', 'Url' => 'index');
        $this->_default[] = array('Title' => 'Pages', 'Url' => 'pages');
        $this->_default[] = array('Title' => 'News', 'Url' => 'news');
        $this->_default[] = array('Title' => 'Gallery', 'Url' => 'gallery');

        $this->_prefix = 'admin';
    }

    /**
     * Rinomina il metodo che restituisce la stringa html del menu.
     *
     * @return string
     */
    public function menu_Admin()
    {
        return $this->menu();
    }
}

?>