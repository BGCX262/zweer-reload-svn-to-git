<?php

/**
 * @file application/controllers/LoginController.php
 * Il controller della pagina di login.
 *
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @version     $Id: Login.php 141 2011-08-22 16:53:32Z flicofloc@gmail.com $
 */

/**
 * Il controller della pagina di login.
 *
 * @uses        Zwe_Controller_Action_Default
 * @category    application
 * @package     Default
 * @subpackage  Controller
 */
class Zwe_Controller_Application_Login extends Zwe_Controller_Action_Default
{
    /**
     * Inizializza il controller.
     * Non fa nulla se non richiamare il costruttore del padre.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Ciò che dev'essere eseguito prima dell'azione.
     * Nel caso l'utente sia già loggato è inutile che visualizzi di nuovo il form di login, e quindi viene rediretto all'ultima pagina visitata.
     * Nel caso l'utente non sia loggato è inutile che visiti la pagina di logout, e quindi viene rediretto all'azione index, ovvero dove deve fare la login.
     */
    public function preDispatch()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            if('logout' != $this->getRequest()->getActionName())
            {
                $History = new Zend_Session_Namespace('History');
                $this->_redirect($History->last);
            }
        }
        else
        {
            if('logout' == $this->getRequest()->getActionName())
            {
                $this->_helper->_redirector('index');
            }
        }
    }

    /**
     * L'action base.
     * Visualizza il form per loggarsi.
     * Quando viene inviato il form valuta se l'utente ha il permesso di loggarsi e quindi lo reindirizza all'ultima pagina visitata.
     */
    public function indexAction()
    {
        $this->view->form = new App_Form_Login_Login();
        $Request = $this->getRequest();

        if($Request->isPost())
        {
            if($this->view->form->isValid($Request->getPost()))
            {
                if($this->_process($this->view->form->getValues()))
                {
                    $History = new Zend_Session_Namespace('History');
                    $this->_redirect($History->last);
                }
            }
        }
    }

    /**
     * Processa la login per verificare che l'utente possa loggarsi
     *
     * @param array $Values I valori del form, quindi nome utente e password
     * @return bool Se l'utente può loggarsi o meno
     */
    protected function _process(array $Values)
    {
        return Zwe_Model_User::isValidLogin($Values['email'], $Values['password']);
    }

    /**
     * L'action per il logout.
     * Elimina l'identità dell'utente e lo reindirizzi alla root del sito.
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

    /**
     * L'action per recuperare la password.
     * Mette a disposizione una form per inserire il proprio indirizzo email.
     * Quindi viene mandata una mail a quell'indirizzo (sempre che esista nel db) con un link per resettare la password.
     */
    public function recoveremailAction()
    {
        $this->view->form = new App_Form_Login_RecoverEmail();
        $this->view->emailSent = false;

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                $Email = $this->view->form->getValue('email');
                $this->view->isOK = Zwe_Model_User::sendResetPassword($Email);

                $this->view->emailSent = true;
            }
        }
    }

    /**
     * L'action per inserire la nuoav password.
     * Visualizza una form in cui inserire la nuova password per l'account.
     */
    public function recoverpasswordAction()
    {
        $User = $this->_getParam('user');
        $Salt = $this->_getParam('salt');
        $this->view->form = new App_Form_Login_RecoverPassword();

        $this->view->form->getElement('salt')->setValue($Salt);
        $this->view->form->getElement('user')->setValue($User);

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                $this->view->OK = Zwe_Model_User::changePassword($User, $this->view->form->getValue('password'), $Salt);
            }
        }
    }

    /**
     * L'action per registrare un nuovo account.
     */
    public function registerAction()
    {
        $this->view->form = new App_Form_Login_Register();
        $this->view->OK = false;

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Zwe_Model_User::addUser($this->view->form->getValue('email'),
                                        $this->view->form->getValue('password'));

                $this->view->OK = true;
            }
        }
    }

    /**
     * L'action per confermare una nuova iscrizione.
     */
    public function confirmAction()
    {
        $User = $this->_getParam('user');
        $Salt = $this->_getParam('salt');

        Zwe_Model_User::confirmUser($User, $Salt);

        $this->_helper->_redirector('index');
    }
}

?>