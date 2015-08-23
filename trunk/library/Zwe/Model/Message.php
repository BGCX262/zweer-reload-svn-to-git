<?php

/**
 * @file library/Zwe/Model/Message.php
 * Il modello del messaggio tra utenti.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @version     $Id: Message.php 164 2011-10-07 15:52:04Z flicofloc@gmail.com $
 */

/**
 * Il modello del messaggio tra utenti.
 *
 * @uses        Zwe_Model
 * @category    Zwe
 * @package     Zwe_Model
 */
class Zwe_Model_Message extends Zwe_Model
{
    protected $_name = 'message';
    protected $_primary = 'IDMessage';

    /**
     * Il mittente del messaggio.
     *
     * @var Zwe_Model_User
     */
    protected $_sender = null;
    /**
     * I destinatari del messaggio.
     * Se è solo uno è comunque un array.
     *
     * @var array
     */
    protected $_receiver = null;
    /**
     * Il messaggio padre.
     * Se fosse uguale a se stesso significa che è lui il messaggio padre.
     *
     * @var Zwe_Model_Message
     */
    protected $_parent = null;

    public static function getMessageById($IDMessage)
    {
        $Message = new self();
        return $Message->fetchRowAndSet("IDMessage = '$IDMessage'");
    }

    public static function createMessage($Receivers, $Text, $Sender = null)
    {
        if(!isset($Sender))
            $Sender = Zend_Auth::getInstance()->getIdentity()->IDUser;

        $Data = array('IDSender' => $Sender, 'Text' => $Text, 'Date' => new Zend_Db_Expr('NOW()'), 'DateLastMessage' => new Zend_Db_Expr('NOW()'));

        $Message = new self();
        $IDMessage = $Message->insert($Data);

        $Data = array('IDParent' => $IDMessage, 'IDLastMessage' => $IDMessage);
        $Message->update($Data, "IDMessage = '$IDMessage'");

        if(!in_array($Sender, $Receivers))
            array_push($Receivers, $Sender);
        Zwe_Model_MessageReceiver::insertReceivers($IDMessage, $Receivers);
    }

    public static function replyMessage($IDParent, $Text, $Sender = null)
    {
        if(!isset($Sender))
            $Sender = Zend_Auth::getInstance()->getIdentity()->IDUser;

        $Data = array('IDSender' => $Sender, 'Text' => $Text, 'Date' => new Zend_Db_Expr("NOW()"), 'IDParent' => $IDParent);

        $Message = new self();
        $IDMessage = $Message->insert($Data);

        if($IDMessage)
        {
            $Data = array('IDLastMessage' => $IDMessage, 'DateLastMessage' => new Zend_Db_Expr("NOW()"));
            $Message->update($Data, "IDMessage = '$IDParent'");
        }

        return $IDMessage;
    }

    public function getSender()
    {
        if(!isset($this->_sender))
        {
            $this->_sender = Zwe_Model_User::getUserById($this->IDSender);
        }

        return $this->_sender;
    }

    public function getReceiver()
    {
        if(!isset($this->_receiver))
        {
            $Receivers = Zwe_Model_MessageReceiver::getReceiversFromIDMessage($this->IDParent);
            $this->_receiver = array();

            foreach($Receivers as $Receiver)
            {
                $this->_receiver[] = Zwe_Model_User::getUserById($Receiver->IDUser);
            }
        }

        return $this->_receiver;
    }

    public function isReceiver($IDUser = null)
    {
        if(!isset($IDUser))
            $IDUser = Zend_Auth::getInstance()->getIdentity()->IDUser;

        $Found = false;
        foreach($this->Receiver as $Receiver)
            if($Receiver->IDUser == $IDUser)
                $Found = true;

        return $Found;
    }

    public function isMultipleReceiver()
    {
        return $this->_data['Receiver'] == '0';
    }

    public function getTheOther($Myself = null)
    {
        if(!isset($Myself))
        {
            $Myself = Zend_Auth::getInstance()->getIdentity()->IDUser;
        }

        if($this->getSender()->IDUser == $Myself)
        {
            $Receivers = $this->getReceiver();
            if(!is_array($Receivers))
                $Receivers = array($Receivers);

            foreach($Receivers as $Receiver)
            {
                if($Receiver->IDUser != $Myself)
                    return $Receiver;
            }

            return $Receiver;
        }
        else
            return $this->getSender();
    }

    public function getParent()
    {
        if(!isset($this->_parent) && !$this->isParent() && !$this->isChatParent())
        {
            $this->_parent = self::getMessageById($this->_data['IDParent']);
        }

        return $this->_parent;
    }

    public function isParent()
    {
        return $this->_data['IDParent'] == $this->_data['IDMessage'];
    }

    public function isChat()
    {
        return $this->_data['IDParent'] == '0' || $this->getParent()->isChat();
    }

    public function isChatParent()
    {
        return $this->_data['IDParent'] == '0';
    }

    public function __get($Name)
    {
        switch($Name)
        {
            case 'Sender':
                return $this->getSender();
            break;

            case 'Receiver':
                return $this->getReceiver();
            break;

            case 'TheOther':
                if($this->Sender->IDUser != Zend_Auth::getInstance()->getIdentity()->IDUser)
                    return $this->Sender;
                else
                    return $this->Receiver[0];
            break;

            default:
                return parent::__get($Name);
            break;
        }
    }
}

?>