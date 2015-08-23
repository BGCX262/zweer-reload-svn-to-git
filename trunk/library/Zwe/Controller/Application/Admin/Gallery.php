<?php

class Zwe_Controller_Application_Admin_Gallery extends Zwe_Controller_Action_Admin
{
    public $contexts = array('parent' => array('json'));

    public function init()
    {
        $this->view->title = 'Gallery';
        parent::init();
    }

    public function indexAction()
    {
        $this->view->pages = Zwe_Model_Page_Gallery::getGalleryPages();
    }

    public function newAction()
    {
        $this->view->form = new Admin_Form_Album();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_Album::addAlbum($this->view->form->getValue('title'),
                                          $this->view->form->getValue('page'),
                                          $this->view->form->getValue('description'));

                $this->_helper->redirector('index');
            }
        }
    }

    public function editAction()
    {
        $this->view->form = new Admin_Form_Album();
        $this->view->form->addID();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_Album::editAlbum($this->view->form->getValue('id'),
                                           $this->view->form->getValue('title'),
                                           $this->view->form->getValue('page'),
                                           $this->view->form->getValue('description'));

                $this->_helper->redirector('index');
            }
        }

        $Album = Zwe_Model_Album::getAlbumByID((int) $this->_getParam('album'));
        $this->view->form->populate($Album->toForm());
        $this->view->form->getElement('album')->setLabel('Edit the album');
    }

    /**
     * #todo Cancellare anche le foto dell'album
     */
    public function deleteAction()
    {
        Zwe_Model_Album::deleteAlbum((int) $this->_getParam('album'));

        $this->_helper->redirector('index');
    }

    public function parentAction()
    {
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost())
        {
            $Data = $this->getRequest()->getPost();
            if($Data['album'] && $Data['page'])
            {
                Zwe_Model_Album::parentAlbum((int) $Data['album'], (int) $Data['page']);
                $this->view->message = "Album parent page changes successfully";
            }
        }
    }
}

?>