<?php

class Zwe_Controller_Action_Default extends Zwe_Controller_Action
{
    protected $_title = '';

    /**
     * Inizializzazione del controller.
     * Si occupa di memorizzare la pagina e il titolo.
     */
    public function init()
    {
        $this->view->thePage = Zwe_Model_Page::getThisPage();
        $this->view->title = $this->view->thePage->Title;
        if(!$this->view->title)
            $this->view->title = $this->_title;

        if($this->view->title)
            $this->view->headTitle()->append($this->view->title);
    }
}

?>