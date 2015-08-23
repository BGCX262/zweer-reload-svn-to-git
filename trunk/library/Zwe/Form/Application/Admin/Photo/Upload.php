<?php

class Zwe_Form_Application_Admin_Photo_Upload extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_photo_upload');
        $this->setMethod(self::METHOD_POST);
        $this->setEnctype(self::ENCTYPE_MULTIPART);
        $this->setAction($this->getView()->url(array('controller' => 'photo', 'action' => 'upload', 'module' => 'admin'), 'default'));

        $this->addElement('file',
                          'url',
                          array('required' => true,
                                'label' => 'Image:',
                                'isArray' => true));
        $this->getElement('url')->clearDecorators()
                                ->addDecorator('File')
                                ->addDecorator('Errors')
                                ->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
                                ->addDecorator('Label', array('id' => 'url-0'))
                                ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'formRow'));

        $this->addElement('submit',
                          'photo_upload',
                          array('label' => 'Upload new photos'));
        $this->getElement('photo_upload')->clearDecorators()
                                         ->addDecorator('Tooltip')
                                         ->addDecorator('ViewHelper')
                                         ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'formSubmit'));

        $this->addElement('hidden',
                          'album');
        $this->getElement('album')->clearDecorators()
                                  ->addDecorator('ViewHelper');

        $this->addDecorator('FormElements')
             ->addDecorator('Fieldset', array('legend' => 'Upload Photos'))
             ->addDecorator('Form');
    }
}

?>