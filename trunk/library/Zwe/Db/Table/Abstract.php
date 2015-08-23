<?php

abstract class Zwe_Db_Table_Abstract extends Zend_Db_Table_Abstract
{
    /**
     * Array con tutti i dati del modello.
     *
     * @var Zend_Db_Table_Row_Abstract|Zend_Db_Table_Rowset_Abstract
     */
    protected $_data = null;

    /**
     * Getter dell'array dei dati del modello.
     *
     * @return Zend_Db_Table_Row_Abstract|Zend_Db_Table_Rowset_Abstract
     */
    public function getData()
    {
        return $this->_data;
    }

    public function select($withFromPart = self::SELECT_WITHOUT_FROM_PART)
    {
        $Select = parent::select($withFromPart);
        $Select->assemble();
        $Select->setIntegrityCheck(false);

        return $Select;
    }

    public function copy(Zwe_Db_Table_Abstract $Object)
    {
        $this->_data = $Object->getData();

        return $this;
    }

    public function copyFromDb($Object)
    {
        $this->_data = $Object;

        return $this;
    }
}

?>