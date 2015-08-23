<?php

/**
 * @file library/Zwe/View/Helper/Menu.php
 * La classe astratta per i menu.
 *
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 * @version     $Id: Menu.php 70 2011-07-27 14:04:10Z flicofloc@gmail.com $
 */

/**
 * La classe astratta per i menu.
 * Definite la struttura base e quindi il metodo che ritorna l'elenco con le varie voci (che poi andrà rinominato in ogni classe figlia).
 * Bisogna reimplementare in ogni figlio la classe astratta setDefault() che inserisce le voci del menu.
 *
 * @uses        Zend_View_Helper_Abstract
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper_Menu
 */
abstract class Zwe_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    /**
     * L'array contenente tutte le voci del menu.
     * Ogni voce dev'essere un array associativo con queste voci:
     * - Url: l'indirizzo della pagina linkata
     * - Title: il titolo della pagina linkata
     *
     * @see setDefault()
     * @var array
     */
    protected $_default = array();

    /**
     * Il prefisso da inserire nel link.
     * Viene usato dal menu di admin e dai sottomenu.
     *
     * @var string
     */
    protected $_prefix = '';

    /**
     * Il costruttore.
     * Si occupa di richiamare il metodo per inizializzare il menu.
     */
    public function __construct()
    {
        $this->setDefault();
    }

    /**
     * Il metodo che va reimplementato ogni volta.
     * Si occupa di inizializzare l'array con le voci del menu.
     * 
     * @see $_default
     * @abstract
     */
    abstract protected function setDefault();

    /**
     * Ritorna la stringa con l'html per il menu.
     * Va a leggere le voci da $_default.
     *
     * @return string L'html con il menu
     */
    public function menu()
    {
        $Ret  = '<ul>';
        foreach($this->_default as $Menu)
            $Ret .= '<li><a href="/' . ($this->_prefix ? $this->_prefix . '/' : '') . $Menu['Url'] . '" title="' . $Menu['Title'] . '">' . $Menu['Title'] . '</a></li>';
        $Ret .= '</ul>';

        return $Ret;
    }
}

?>