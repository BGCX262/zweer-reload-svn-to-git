<?php

class Zwe_Model_Chat extends Zwe_Model
{
    protected $_name = 'chat';
    protected $_primary = 'IDChat';

    /**
     * @var int
     */
    protected static  $_interval = 30;

    protected $_template = '<div class="chat_message"><span class="chat_message_date">%date%</span><span class="chat_message_author">%author%</span><span class="chat_message_text">%text%</span></div>';

    /**
     * @static
     * @return int
     */
    public static function getInterval()
    {
        return self::$_interval;
    }

    /**
     * @static
     * @param int $interval
     */
    public static function setInterval($interval)
    {
        self::$_interval = (int) $interval;
    }

    public static function getNew($IDParent, $lastID)
    {
        $TheChat = new self();
        $Messages = $TheChat->fetchAll("IDParent = '$IDParent' AND IDChat > $lastID AND Date + INTERVAL 20 MINUTE > NOW()", "Date");
        $Ret = array();

        if($Messages)
        {
            foreach($Messages as $Message)
            {
                $TheChat = new self();
                $Ret[] = $TheChat->copyFromDb($Message);
            }
        }

        return $Ret;
    }

    public static function addChat($IDParent, $Text, $IDUser = null)
    {
        if(!isset($IDUser))
            $IDUser = Zend_Auth::getInstance()->getIdentity()->IDUser;

        $TheChat = new self();
        $Data = array('IDParent' => $IDParent, 'Text' => $Text, 'IDUser' => $IDUser, 'Date' => new Zend_Db_Expr('NOW()'));

        return $TheChat->insert($Data);
    }

    public function __toString()
    {
        $date = new Zend_Date($this->Date);
        $author = Zwe_Model_User::getUserById($this->IDUser);

        return str_replace(array('%date%', '%author%', '%text%'), array($date, $author, $this->Text), $this->_template);
    }
}