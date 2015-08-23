<?php

class Zwe_Controller_Application_Calendar extends Zwe_Controller_Action_Default
{
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $this->view->calendar = new Zwe_Calendar(array('timestamp' => 'May 08, 2011'));
    }
}

?>