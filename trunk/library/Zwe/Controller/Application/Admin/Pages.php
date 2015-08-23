<?php

class Zwe_Controller_Application_Admin_Pages extends Zwe_Controller_Action_Admin
{
    public $contexts = array('order' => array('json'));

    public function init()
    {
        $this->view->title = 'Pages';
        parent::init();
    }

    public function indexAction()
    {
        $this->view->tree = Zwe_Model_Page::getTree();
    }

    public function newAction()
    {
        $this->view->form = new Admin_Form_Page();

        if($this->getRequest()->isPost())
        {
            $FormData = $this->getRequest()->getPost();
            $this->view->form->addUrlValidator($FormData['parent']);
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_Page::addPage($this->view->form->getValue('title'),
                                        $this->view->form->getValue('parent'),
                                        $this->view->form->getValue('url'),
                                        $this->view->form->getValue('type'),
                                        $this->view->form->getValue('text'));

                $this->_helper->redirector('index');
            }
        }
    }

    public function editAction()
    {
        $this->view->form = new Admin_Form_Page();
        $this->view->form->addID();

        if($this->getRequest()->isPost())
        {
            $FormData = $this->getRequest()->getPost();
            $this->view->form->addUrlValidator($FormData['parent'], $FormData['id']);
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_Page::editPage($this->view->form->getValue('id'),
                                         $this->view->form->getValue('title'),
                                         $this->view->form->getValue('parent'),
                                         $this->view->form->getValue('url'),
                                         $this->view->form->getValue('type'),
                                         $this->view->form->getValue('text'));

                $this->_helper->redirector('index');
            }
        }

        $Page = Zwe_Model_Page::getPageByID($this->getRequest()->getParam('page'));
        $this->view->form->populate($Page->toForm());
        $this->view->form->getElement('page')->setLabel('Edit the page');
    }

    public function deleteAction()
    {
        Zwe_Model_Page::deletePage($this->getRequest()->getParam('page'));

        $this->_helper->redirector('index');
    }

    public function orderAction()
    {
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost())
        {
            $Data = $this->getRequest()->getPost();
            if($Data['order'])
            {
                Zwe_Model_Page::orderPages(Zend_Json::decode(stripslashes($Data['order'])));
                $this->view->message = "Page order was changed successfully";
            }
        }
    }
}

?>