<?php

/**
 * @file application/forms/Login/Login.php
 * La form per la pagina di login.
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: Login.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la pagina di login.
 * Costruisce una form con un campo di testo (Email) e un campo password.
 * Completa il tutto con un bel bottone per inviare il modulo.
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Login_Login extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_login');
        $this->setMethod(Zend_Form::METHOD_POST);

        $this->addElement('text',
                          'email',
                          array('filters' => array('StringTrim'),
                                'required' => true,
                                'label' => 'Email Address:'));

        $this->addElement('password',
                          'password',
                          array('filters' => array('StringTrim'),
                                'required' => true,
                                'label' => 'Password:'));

        $this->addElement('submit',
                          'login',
                          array('label' => 'Login'));

        $Token = new Zend_Form_Element_Hash('token');
        $Token->setSalt(sha1(uniqid(mt_rand(), true)));
        $Token->setTimeout(60);
        $this->addElement($Token);
    }
}

?>