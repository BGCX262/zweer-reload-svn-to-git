<?php

/**
 * @file library/Zwe/Model.php
 * Classe padre di tutti i modelli.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @version     $Id: Model.php 97 2011-07-29 17:09:15Z flicofloc@gmail.com $
 */

/**
 * Classe padre di tutti i modelli.
 * Estende la classe del database e implementa metodi utili come l'autoassegnazione dell'attributo data.
 *
 * @throws      Exception
 * @uses        Zend_Db_Table_Abstract
 * @category    Zwe
 * @package     Zwe_Model
 */
abstract class Zwe_Model extends Zwe_Db_Table_Abstract
{
    /**
     * Interroga il database e assegna il risultato ai dati.
     *
     * @throws Exception Viene lanciata se non si trovano risultati
     * @param string $where La clausola Where della query
     * @param string $order La clausola Order della query
     * @param int $offset La clausola Limit della query
     * @return Zwe_Model Il modello stesso
     */
    public function fetchRowAndSet($where = null, $order = null, $offset = null)
    {
        $this->_data = $this->fetchRow($where, $order, $offset);
        if(!$this->_data)
            throw new Exception("Errore nell'interrogazione al database");

        return $this;
    }

    public function copy(Zwe_Model $Object)
    {
        return parent::copy($Object);
    }

    public function copyFromDb(Zend_Db_Table_Row_Abstract $Object)
    {
        return parent::copyFromDb($Object);
    }

    public function __get($Name)
    {
        if($this->_data instanceof Zend_Db_Table_Row_Abstract && isset($this->_data->$Name))
            return $this->_data->$Name;
        elseif(is_array($this->_data) && array_key_exists($Name, $this->_data))
            return $this->_data[$Name];
        else
            throw new Exception("Specified field '$Name' is not part of the data");
    }

    public function __set($Name, $Value)
    {
        if(!isset($this->_data))
            $this->_data = array();

        if($this->_data instanceof Zend_Db_Table_Row_Abstract)
            $this->_data->$Name = $Value;
        elseif(is_array($this->_data))
            $this->_data[$Name] = $Value;
        else
            throw new Exception("'this->_data' is not a valid object or array");
    }
}

?>