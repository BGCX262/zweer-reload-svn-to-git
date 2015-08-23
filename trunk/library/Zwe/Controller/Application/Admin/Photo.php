<?php

class Zwe_Controller_Application_Admin_Photo extends Zwe_Controller_Action_Admin
{
    public function init()
    {
        $this->view->title = 'Photo Manage';
        parent::init();
    }

    public function indexAction()
    {
        $IDAlbum = $this->_getParam('album');
        if(!isset($IDAlbum))
            $this->_helper->redirector('index', 'gallery');

        $this->view->album = Zwe_Model_Album::getAlbumByID($IDAlbum);
        $this->view->uploadForm = new Admin_Form_Photo_Upload();
        $this->view->uploadForm->getElement('album')->setValue($IDAlbum);

        $this->view->deleteForm = new Admin_Form_Photo_Delete();
        $this->view->deleteForm->getElement('delete')->addMultiOptions($this->view->album->Photos);
    }

    public function uploadAction()
    {
        $this->view->uploadForm = new Admin_Form_Photo_Upload();

        if($this->getRequest()->isPost())
        {
            if($this->view->uploadForm->isValid($this->getRequest()->getPost()))
            {
                $Dir  = PUBLIC_PATH . '/images/gallery/';
                if(!is_dir($Dir))
                    mkdir($Dir);
                $Dir .= $this->view->uploadForm->getValue('album') . '/';
                if(!is_dir($Dir))
                    mkdir($Dir);

                $this->view->uploadForm->getElement('url')->setDestination($Dir);
                $this->view->uploadForm->getElement('url')->receive();
                die(print_r($this->view->uploadForm->getElement('url')->getFileInfo(), true));

                $this->_helper->_redirector->gotoRoute(array('album' => $this->view->uploadForm->getValue('album')), 'photo');
            }
        }
    }

    protected function uploadImages()
    {
        $Dir  = TEMP_PATH . '/';
        if(!is_dir($Dir))
            mkdir($Dir);

        $this->view->uploadForm->getElement('url')->setDestination($Dir);
        $this->view->uploadForm->getElement('url')->receive();
        $this->moveImage($this->view->uploadForm->getElement('url')->getFileName());
    }

    protected function moveImage($Image)
    {
        if(is_array($Image))
            foreach($Image as $I)
                $this->moveImage($I);
        else
        {
            $FileName = substr($Image, strrpos($Image, '/') + 1);
            $Extension = substr($FileName, strrpos($FileName, '.') + 1);
            $Name = substr($FileName, 0, strrpos($FileName, '.'));

            $IDPhoto = Zwe_Model_Photo::addPhoto($this->view->uploadForm->getValue('album'), $Name, $Extension);
        }
    }
}

?>