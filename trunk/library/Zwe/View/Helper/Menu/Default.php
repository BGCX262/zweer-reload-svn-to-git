<?php

/**
 * @file library/Zwe/View/Helper/Menu/Default.php
 * Il menu per le pagine della parte pubblica.
 *
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 * @version     $Id: Default.php 75 2011-07-27 17:19:52Z flicofloc@gmail.com $
 */

/**
 * Il menu per le pagine della parte pubblica.
 * Il menu viene generato dinamicamente andando a vedere nel database quali sono le pagine figlie della root, e quindi le mette in ordine per Position.
 *
 * @uses        Zwe_View_Helper_Menu
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 */
class Zwe_View_Helper_Menu_Default extends Zwe_View_Helper_Menu
{
    /**
     * Imposta i valori di default del menu.
     * Va a interrogare il database, ricercando quali sono le pagine figlie della root.
     */
    protected function setDefault()
    {
        $Menu = Zwe_Model_Page::getMenu();

        foreach($Menu as $M)
        {
            $this->_default[] = array('Url' => $M['Url'], 'Title' => $M['Title']);
        }
    }

    /**
     * Rinomina il metodo che restituisce la stringa html del menu.
     *
     * @return string
     */
    public function menu_Default()
    {
        return $this->menu();
    }
}

?>