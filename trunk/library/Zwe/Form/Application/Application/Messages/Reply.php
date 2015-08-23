<?php

/**
 * @file application/forms/Messages/Reply.php
 * La form per la risposta a un vecchio messaggio.
 *
 * @category    application
 * @package     Default
 * @subpackage  Form
 * @version     $Id: Reply.php 128 2011-08-05 10:23:13Z flicofloc@gmail.com $
 */

/**
 * La form per la risposta a un vecchio messaggio.
 * C'è solo il campo per il testo, visto che il resto non serve (no bhè, c'è anche un campo nascosto con l'id del padre).
 *
 * @uses        Zwe_Form
 * @category    application
 * @package     Default
 * @subpackage  Form
 */
class Zwe_Form_Application_Application_Messages_Reply extends Zwe_Form
{
    /**
     * L'inizializzazione del form, dove vengono scritti i vari campi che lo comporranno.
     */
    public function init()
    {
        $this->setName('form_reply_message');
        $this->setMethod('post');

        $this->addElement('textarea',
                          'text',
                          array('required' => true,
                                'label' => 'Reply:',
                                'filters' => array('StringTrim')));

        $this->addElement('submit',
                          'reply',
                          array('label' => 'Send Reply'));

        $this->addElement('hidden',
                          'parent');
    }
}

?>