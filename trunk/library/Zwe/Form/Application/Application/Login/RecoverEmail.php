<?php

/**
 * @file application/forms/Login/RecoverEmail.php
 * La form per la pagina di recupero della password (inserimento email).
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: RecoverEmail.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la pagina di recupero della password (inserimento email).
 * Costruisce una form con un campo di testo (Email).
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Login_RecoverEmail extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_recover_email');
        $this->setMethod('post');

        $this->addElement('text',
                          'email',
                          array('required' => true,
                                'label' => 'Email:',
                                'filters' => array('StringTrim')));

        $this->addElement('submit',
                          'recover_email',
                          array('label' => 'Send Recover Message'));
    }
}

?>