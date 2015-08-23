<?php

class Zwe_Controller_Plugin_RefreshOnline extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            Zwe_Model_Online::refreshOnline();
        }
    }
}