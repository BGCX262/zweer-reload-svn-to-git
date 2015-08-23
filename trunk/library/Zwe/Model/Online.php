<?php

class Zwe_Model_Online extends Zwe_Model
{
    protected $_name = 'online';
    protected $_primary = 'IDOnline';

    protected $_user = null;
    protected $_location = null;

    public static function refreshOnline($IDUser = null, $Location = null)
    {
        if(!isset($IDUser))
            $IDUser = Zend_Auth::getInstance()->getIdentity()->IDUser;

        $TheOnline = new self();
        $Data = array('Date' => new Zend_Db_Expr('NOW()'));
        if(isset($Location))
            $Data['IDLocation'] = $Location;

        $Online = $TheOnline->fetchAll("IDUser = '$IDUser'");
        
        if($Online->count() == 1)
            $TheOnline->update($Data, "IDUser = '$IDUser'");
        else
        {
            if($Online->count() > 1)
                $TheOnline->delete("IDUser = '$IDUser'");

            $Data['IDUser'] = $IDUser;
            $TheOnline->insert($Data);
        }
    }

    public static function getUsersOnline($Age = 1)
    {
        $TheOnline = new self();
        $Onlines = $TheOnline->fetchAll("Date + INTERVAL $Age MINUTE > NOW()", "IDLocation");
        $Ret = array();

        foreach($Onlines as $Online)
        {
            $TheOnline = new self();
            $TheOnline->copyFromDb($Online);

            $TheOnline->User = App_Model_User::getUserById($Online->IDUser);
            if($TheOnline->IDLocation)
                $TheOnline->Location = Mappa_Model_Luogo::get($Online->IDLocation);

            $Ret[] = $TheOnline;
        }

        return $Ret;
    }

    public function __get($Name)
    {
        if('User' == $Name)
            return $this->_user;
        elseif('Location' == $Name)
            return $this->_location;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('User' == $Name)
        {
            if($Value instanceof App_Model_User)
                $this->_user = $Value;
            else
                throw new Exception('Invalid user class');
        }
        elseif('Location' == $Name)
        {
            if($Value instanceof Mappa_Model_Luogo)
                $this->_location = $Value;
            else
                throw new Exception('Invalid location class');
        }
        else
            parent::__set($Name, $Value);
    }
}