<?php

class Zwe_Controller_Application_Admin_News extends Zwe_Controller_Action_Admin
{
    public $contexts = array('parent' => array('json'));

    public function init()
    {
        $this->view->title = 'News';
        parent::init();
    }

    public function indexAction()
    {
        $this->view->pages = Zwe_Model_Page_News::getNewsPages();
    }

    public function newAction()
    {
        $this->view->form = new Admin_Form_News();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_News::addNews($this->view->form->getValue('title'),
                                        $this->view->form->getValue('page'),
                                        $this->view->form->getValue('text'));

                $this->_helper->redirector('index');
            }
        }
    }

    public function editAction()
    {
        $this->view->form = new Admin_Form_News();
        $this->view->form->addID();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_News::editNews($this->view->form->getValue('id'),
                                         $this->view->form->getValue('title'),
                                         $this->view->form->getValue('page'),
                                         $this->view->form->getValue('text'));

                $this->_helper->redirector('index');
            }
        }

        $News = Zwe_Model_News::getNewsByID((int) $this->_getParam('news'));
        $this->view->form->populate($News->toForm());
        $this->view->form->getElement('news')->setLabel('Edit the news');
    }

    public function deleteAction()
    {
        Zwe_Model_News::deleteNews((int) $this->_getParam('news'));

        $this->_helper->redirector('index');
    }

    public function parentAction()
    {
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost())
        {
            $Data = $this->getRequest()->getPost();
            if($Data['news'] && $Data['page'])
            {
                Zwe_Model_News::parentNews((int) $Data['news'], (int) $Data['page']);
                $this->view->message = "News parent page changed successfully";
            }
        }
    }
}

?>