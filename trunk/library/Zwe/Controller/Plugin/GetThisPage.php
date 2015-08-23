<?php

class Zwe_Controller_Plugin_GetThisPage extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        try
        {
            Zwe_Model_Page::getThisPage($request->getRequestUri());
        }
        catch(Exception $E)
        {
            # Do nothing
        }
    }
}

?>