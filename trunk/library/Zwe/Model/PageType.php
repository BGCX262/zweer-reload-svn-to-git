<?php

/**
 * @file library/Zwe/Model/PageType.php
 * Classe che modellizza i tipi delle pagine
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @version     $Id: PageType.php 98 2011-07-30 11:13:47Z flicofloc@gmail.com $
 */

/**
 * Classe che modellizza i tipi delle pagine.
 *
 * @uses        Zwe_Model
 * @category    Zwe
 * @package     Zwe_Model
 */
class Zwe_Model_PageType extends Zwe_Model
{
    protected $_name = 'page_type';
    protected $_primary = 'IDType';

    public static function getType($IDType)
    {
        $Type = new self();
        return $Type->fetchRowAndSet("IDType = '$IDType'");
    }

    public static function getTypes()
    {
        $Type = new self();
        $Types = $Type->fetchAll(null, "Type");

        if($Types)
            return $Types->toArray();
        else
            return array();
    }

    /**
     * Getter del controller del tipo.
     * Il controller coincide col nome del tipo.
     *
     * @return string La classe del controller
     */
    public function getController()
    {
        return $this->_data['Type'];
    }
}

?>