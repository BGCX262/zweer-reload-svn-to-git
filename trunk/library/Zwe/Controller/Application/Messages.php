<?php

/**
 * @file application/controllers/MessagesController.php
 * Il controller deli messaggi
 *
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @version     $Id: Messages.php 141 2011-08-22 16:53:32Z flicofloc@gmail.com $
 */

/**
 * Controller che gestisce le pagine deli messaggi.
 *
 * @uses        Zwe_Controller_Action
 * @category    application
 * @package     Default
 * @subpackage  Controller
 */
class Zwe_Controller_Application_Messages extends Zwe_Controller_Action_Private
{
    /**
     * Inizializza il controller.
     * Non fa nulla se non richiamare l'inizializzatore del padre.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * L'action di base.
     * Non introduce alcuna logica.
     */
    public function indexAction()
    {
        $this->view->conversations = Zwe_Model_Page_Messages::getConversations(Zend_Auth::getInstance()->getIdentity()->IDUser);
    }

    /**
     * L'action per creare un nuovo messaggio.
     */
    public function newAction()
    {
        $this->view->form = new App_Form_Messages_New();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                $Receivers = explode(',', $this->view->form->getValue('receivers'));
                $Text = $this->view->form->getValue('text');

                Zwe_Model_Message::createMessage($Receivers, $Text);

                $this->_helper->redirector('index');
            }
        }
    }

    /**
     * L'action per visualizzare i messaggi di una conversazione.
     */
    public function viewAction()
    {
        $IDMessage = $this->_getParam('message');

        $this->view->form = new App_Form_Messages_Reply();
        $this->view->form->getElement('parent')->setValue($IDMessage);

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_Message::replyMessage($this->view->form->getValue('parent'),
                                                $this->view->form->getValue('text'));
            }
        }

        $this->view->messages = Zwe_Model_Page_Messages::getConversation($IDMessage);
        $this->view->receivers = Zwe_Model_MessageReceiver::getReceiversFromIDMessage($IDMessage);
    }
}

?>