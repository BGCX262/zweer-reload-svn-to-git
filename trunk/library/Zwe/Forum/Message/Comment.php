<?php

class Zwe_Forum_Message_Comment extends Zwe_Forum_Message
{
    protected $_viewScript = 'comment';

    public function isOK()
    {
        return $this->IsForum == 0 && $this->getParent()->IsForum == 0;
    }

    public function printExtended()
    {
        return $this->printMessage();
    }
}