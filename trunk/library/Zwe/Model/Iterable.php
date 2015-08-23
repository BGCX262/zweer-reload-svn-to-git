<?php

class Zwe_Model_Iterable extends Zwe_Db_Table_Abstract implements Iterator
{
    protected $_position = 0;

    /**
     * Interroga il database e assegna il risultato ai dati.
     *
     * @throws Exception Viene lanciata se non si trovano risultati
     * @param string $where La clausola Where della query
     * @param string $order La clausola Order della query
     * @param int $offset La clausola Limit della query
     * @param int $count La clausola Limit della query
     * @return Zwe_Model Il modello stesso
     */
    public function fetchAllAndSet($where = null, $order = null, $count = null, $offset = null)
    {
        $this->_data = $this->fetchAll($where, $order, $count, $offset);
        if(!$this->_data)
            throw new Exception("Errore nell'interrogazione al database");

        return $this;
    }

    public function copy(Zwe_Model_Iterable $Object)
    {
        return parent::copy($Object);
    }

    public function copyFromDb(Zend_Db_Table_Rowset_Abstract $Object)
    {
        return parent::copyFromDb($Object);
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function current()
    {
        return $this->_data[$this->_position];
    }

    public function key()
    {
        $this->_position;
    }

    public function next()
    {
        ++$this->_position;
    }

    public function valid()
    {
        return isset($this->_data[$this->_position]);
    }
}

?>