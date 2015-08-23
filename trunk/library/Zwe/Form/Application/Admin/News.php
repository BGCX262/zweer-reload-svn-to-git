<?php

class Zwe_Form_Application_Admin_News extends Zwe_Form
{
    public function init()
    {
        function FromTypeToOption($Type)
        {
            return array('key' => $Type['IDType'], 'value' => $Type['Type']);
        }

        $this->setName('form_news');
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
        $Options = $this->getView()->getPageSelect(Zwe_Model_Page_News::getNewsPages(true));
        $this->getElement('page')->addMultiOptions($Options);

        $this->addElement('textarea',
                          'text',
                          array('required' => false,
                                'label' => 'Text:',
                                'filters' => array('StringTrim')));
        $this->getElement('text')->setAttrib('id', 'news_text');

        $this->addElement('submit',
                          'news',
                          array('label' => 'Create the news'));
    }

    public function addID()
    {
        $this->addElement('hidden',
                          'id');
    }
}

?>