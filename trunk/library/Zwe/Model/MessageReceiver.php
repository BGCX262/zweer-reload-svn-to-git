<?php

class Zwe_Model_MessageReceiver extends Zwe_Model_Iterable
{
    protected $_name = 'message_receiver';
    protected $_primary = array('IDMessage', 'IDReceiver');

    public static function insertReceivers($IDMessage, $Receivers)
    {
        $Ret = true;

        if(is_array($Receivers))
        {
            foreach($Receivers as $Receiver)
            {
                $Ret &= self::insertReceivers($IDMessage, $Receiver);
            }
        }
        elseif(is_numeric($Receivers))
        {
            $Data = array('IDMessage' => $IDMessage, 'IDUser' => $Receivers);
            $MessageReceiver = new self();
            $Ret = (boolean) $MessageReceiver->insert($Data);
        }

        return $Ret;
    }

    public static function getReceiversFromIDMessage($IDMessage)
    {
        $MessageReceivers = new self();
        return $MessageReceivers->fetchAllAndSet("IDMessage = '$IDMessage'");
    }
}

?>