<?php

/**
 * @file application/forms/Messages/New.php
 * La form per la pagina di creazione di un nuovo messaggio.
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: New.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la pagina di creazione di un nuovo messaggio.
 * Ci sono un campo di testo (per i destinatari del messaggio, magari con autocompletamento) e una textarea per il testo del messaggio.
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Messages_New extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_new_message');
        $this->setMethod('post');

        $this->addElement('text',
                          'receivers',
                          array('required' => true,
                                'label' => 'Receivers:',
                                'filters' => array('StringTrim')));

        $this->addElement('textarea',
                          'text',
                          array('required' => true,
                                'label' => 'Text:',
                                'filters' => array('StringTrim')));

        $this->addElement('submit',
                          'new',
                          array('label' => 'Send Message'));
    }
}

?>