<?php

class Zwe_Form_Application_Admin_Photo_Delete extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_photo_delete');
        $this->setMethod(self::METHOD_POST);
        $this->setAction($this->getView()->url(array('controller' => 'photo', 'action' => 'delete', 'module' => 'admin'), 'default'));

        $this->addElement('multiCheckbox',
                          'delete',
                          array('isArray' => true));
        $this->getElement('delete')->clearDecorators()
                                   ->addDecorator('ViewHelper');

        $this->addElement('submit',
                          'photo_delete',
                          array('label' => 'Delete these photos'));
        $this->getElement('photo_delete')->clearDecorators()
                                         ->addDecorator('Tooltip')
                                         ->addDecorator('ViewHelper');

        $this->addElement('hidden',
                          'album');
        $this->getElement('album')->clearDecorators()
                                  ->addDecorator('ViewHelper');

        $this->addDecorator('FormElements')
             ->addDecorator('Fieldset', array('legend' => 'Modify / Delete photos'))
             ->addDecorator('Form');
    }
}

?>