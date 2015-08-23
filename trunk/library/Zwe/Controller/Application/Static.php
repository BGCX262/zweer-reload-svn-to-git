<?php

/**
 * @file application/controllers/StaticController.php
 * Controller delle pagine statiche.
 *
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @version     $Id: Static.php 141 2011-08-22 16:53:32Z flicofloc@gmail.com $
 */

/**
 * Controller delle pagine statiche.
 * Si preoccupa semplicemente di visualizzare il contenuto della pagina.
 *
 * @uses        Zwe_Controller_Action_Default
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @todo        Gestire gli allegati a una pagina
 * @todo        Gestire una mini photogallery per la pagina
 */
class Zwe_Controller_Application_Static extends Zwe_Controller_Action_Default
{
    /**
     * Inizializza il controller.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * L'azione base, quella che visualizza il contenuto della pagina.
     */
    public function indexAction()
    {

    }
}

