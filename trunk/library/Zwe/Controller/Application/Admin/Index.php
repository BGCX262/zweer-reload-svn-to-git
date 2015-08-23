<?php

/**
 * @file application/modules/admin/IndexController.php
 * Controller di "benvenuto" nell'area admin.
 *
 * @category    application
 * @package     Admin
 * @subpackage  Controller
 * @version     $Id: Index.php 142 2011-08-23 07:28:01Z flicofloc@gmail.com $
 */

/**
 * Controller di "benvenuto" nell'area admin.
 * Mostra una pagina statica (in futuro magari statistiche o notifiche)
 *
 * @uses        Zwe_Controller_Action
 * @category    application
 * @package     Admin
 * @subpackage  Controller
 */
class Zwe_Controller_Application_Admin_Index extends Zwe_Controller_Action_Admin
{
    /**
     * Inizializza il controller.
     */
    public function init()
    {
        $this->view->title = 'Homepage';
        parent::init();
    }

    /**
     * L'azione base, quella che visualizza il contenuto della pagina.
     */
    public function indexAction()
    {

    }
}

