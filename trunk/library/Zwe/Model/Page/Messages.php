<?php

/**
 * @file library/Zwe/Model/Page/Messages.php
 * Il modello della pagina dei messaggi.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_Page
 * @version     $Id: Messages.php 112 2011-08-01 14:57:36Z flicofloc@gmail.com $
 */

/**
 * Il modello della pagina dei messaggi.
 * E' una pagina fissa, quindi non può pescare le informazioni dal database.
 * Per compatibilità vengono settate a mano tutte le informazioni.
 *
 * @uses        Zwe_Model_Page
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_Page
 */
class Zwe_Model_Page_Messages extends Zwe_Model_Page
{
    /**
     * I messaggi da visualizzare
     *
     * @var array
     */
    protected $_messages = array();

    /**
     * L'uri della pagina dei messaggi.
     *
     * @var string
     */
    const MESSAGES_URL = '/messages';

    /**
     * Quante conversazioni stanno in una pagina.
     *
     * @var int
     */
    const CONVERSATIONS_PER_PAGE = 20;

    public static function getConversations($IDUser, $Page = 0)
    {
        $Message = new Zwe_Model_Message();
        $Select = $Message->select()->join(array('mm' => 'message'), 'message.IDMessage = mm.IDLastMessage', array())
                                    ->join(array('r' => 'message_receiver'), 'mm.IDMessage = r.IDMessage', 'IDUser')
                                    ->where("IDUser = '$IDUser' AND mm.IDParent = mm.IDMessage AND Deleted = '0'")
                                    ->order("mm.DateLastMessage DESC")
                                    ->limitPage($Page + 1, self::CONVERSATIONS_PER_PAGE);
        $RowConversations = $Message->fetchAll($Select);
        $Conversations = array();

        if($RowConversations)
        {
            foreach($RowConversations as $RowConversation)
            {
                $M = new Zwe_Model_Message();
                $Conversations[] = $M->copyFromDb($RowConversation);
            }
        }

        return $Conversations;
    }

    public static function getConversation($IDConversation)
    {
        $TheMessage = new Zwe_Model_Message();
        $Select = $TheMessage->select()->where("IDParent = '$IDConversation'")
                                    ->order("Date");
        $Conversation = $TheMessage->fetchAll($Select);
        $Messages = array();

        if($Conversation)
        {
            foreach($Conversation as $Message)
            {
                $M = new Zwe_Model_Message();
                $Messages[] = $M->copyFromDb($Message);
            }
        }

        return $Messages;
    }

    /**
     * L'inizializzazione dell'oggetto.
     * Si assegna il titolo della pagina a mano.
     *
     * @param array $config
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->Title = 'Messages';
    }

    public function __get($Name)
    {
        if('Messages' == $Name)
            return $this->_messages;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('Messages' == $Name)
        {
            if(is_array($Value))
                $this->_messages = $Value;
            else
                throw new Exception('$Value must be an array');
        }
        else
            parent::__set($Name, $Value);
    }
}

?>