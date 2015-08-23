<?php

class Zwe_Form_Application_Admin_Album extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_album');
        $this->setMethod('post');

        $this->addElement('text',
                          'title',
                          array('required' => true,
                                'label' => 'Title:',
                                'filters' => array('StringTrim')));

        $this->addElement('select',
                          'page',
                          array('required' => true,
                                'label' => 'Parent Page:'));
        $Options = $this->getView()->getPageSelect(Zwe_Model_Page_Gallery::getGalleryPages(true));
        $this->getElement('page')->addMultiOptions($Options);

        $this->addElement('textarea',
                          'description',
                          array('label' => 'Description:',
                                'filters' => array('StringTrim')));

        $this->addElement('submit',
                          'album',
                          array('label' => 'Create the album'));
    }

    public function addID()
    {
        $this->addElement('hidden',
                          'id');
    }
}

?>