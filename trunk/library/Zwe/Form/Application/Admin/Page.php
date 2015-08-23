<?php

class Zwe_Form_Application_Admin_Page extends Zwe_Form
{
    public function init()
    {
        function FromTypeToOption($Type)
        {
            return array('key' => $Type['IDType'], 'value' => $Type['Type']);
        }

        $this->setName('form_page');
        $this->setMethod('post');

        $this->addElement('text',
                          'title',
                          array('required' => true,
                                'label' => 'Title:',
                                'filters' => array('StringTrim')));

        $this->addElement('select',
                          'parent',
                          array('required' => true,
                                'label' => 'Parent:'));
        $Options = $this->getView()->getPageSelect(Zwe_Model_Page::getTree());
        $this->getElement('parent')->addMultiOption('0', 'Root');
        $this->getElement('parent')->addMultiOptions($Options);

        $this->addElement('text',
                          'url',
                          array('required' => true,
                                'label' => 'Url:',
                                'filters' => array('StringTrim')));
        $this->getElement('url')->addValidator(new Zwe_Validate_Url());

        $this->addElement('select',
                          'type',
                          array('required' => true,
                                'label' => 'Type:'));
        $Types = Zwe_Model_PageType::getTypes();
        $this->getElement('type')->addMultiOptions(array_map("FromTypeToOption", $Types));

        $this->addElement('textarea',
                          'text',
                          array('required' => false,
                                'label' => 'Text:',
                                'filters' => array('StringTrim')));
        $this->getElement('text')->setAttrib('id', 'page_text');

        $this->addElement('submit',
                          'page',
                          array('label' => 'Create the page'));
    }

    public function addID()
    {
        $this->addElement('hidden',
                          'id');
    }

    public function addUrlValidator($IDParent, $IDPage = null)
    {
        $this->getElement('url')->addValidator(new Zwe_Validate_Db_NoUrlExist($IDParent, $IDPage));
    }
}

?>