<?php

/**
 * @file application/forms/Login/RecoverPassword.php
 * La form per la pagina di recupero della password (inserimento nuova password).
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: RecoverPassword.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la pagina di recupero della password (inserimento nuova password).
 * Costruisce una form con due campi di testo (password e re-inserisci password).
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Login_RecoverPassword extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_recover_password');
        $this->setMethod('post');

        $this->addElement('hidden',
                          'salt');

        $this->addElement('hidden',
                          'user');

        $this->addElement('password',
                          'password',
                          array('required' => true,
                                'label' => 'New Password:',
                                'filters' => array('StringTrim')));

        $this->addElement('password',
                          'password2',
                          array('required' => true,
                                'label' => 'Reinsert the Password:',
                                'filters' => array('StringTrim'),
                                'validators' => array(array('identical', false, array('token' => 'password')))));

        $this->addElement('submit',
                          'recover_email',
                          array('label' => 'Set new password'));
    }
}

?>