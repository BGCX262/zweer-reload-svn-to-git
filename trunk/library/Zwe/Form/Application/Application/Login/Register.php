<?php

/**
 * @file application/forms/Login/Register.php
 * La form per la pagina di registrazione al sito.
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: Register.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la pagina di registrazione al sito.
 * Costruisce una form dove inserire le informazioni necessarie all'iscrizione al sito.
 * Completa il tutto con una bellissima immagine captcha.
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Login_Register extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_register');
        $this->setMethod(Zend_Form::METHOD_POST);

        $this->addElement('text',
                          'email',
                          array('required' => true,
                                'label' => "Email address:",
                                'filters' => array('StringTrim'),
                                'validators' => array(array('EmailAddress'),
                                                      array('Db_NoRecordExists', false, array('table' => 'user',
                                                                                              'field' => 'Email')))));

        $this->addElement('password',
                          'password',
                          array('required' => true,
                                'label' => 'Password:',
                                'filters' => array('StringTrim')));

        $this->addElement('password',
                          'password2',
                          array('required' => true,
                                'label' => 'Reinsert the password:',
                                'filters' => array('StringTrim'),
                                'validators' => array(array('Identical', false, array('token' => 'password')))));

        $this->addElement('captcha',
                          'captcha',
                          array('label' => 'Write what you see:',
                                'captcha' => array('captcha' => 'Image',
                                                   'wordLen' => 8,
                                                   'timeout' => 300,
                                                   'imgAlt' => 'captcha',
                                                   'imgDir' => PUBLIC_PATH . '/images/captcha',
                                                   'imgUrl' => $this->getView()->import_Img('/captcha', array('url' => true)),
                                                   'font' => '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf')));

        $this->addElement('submit',
                          'register',
                          array('label' => 'Register'));
    }
}

?>