<?php

/**
 * @file application/modules/admin/Bootstrap.php
 * Contiene la classe di Bootstrap per inizializzare il modulo di admin.
 *
 * @category    Site
 * @package     Admin
 * @subpackage  Bootstrap
 * @version     $Id: Bootstrap.php 144 2011-08-23 10:24:32Z flicofloc@gmail.com $
 */

/**
 * Gestisce l'inizializzazione del modulo di admin.
 * Fa partire tutte le funzioni "_init" in modo da applicare tutti i settaggi necessari per l'esecuzione dell'applicazione.
 *
 * @uses        Zend_Application_Bootstrap_Bootstrap
 * @category    Site
 * @package     Admin
 * @subpackage  Bootstrap
 */
abstract class Zwe_Application_Bootstrap_Application_Module extends Zend_Application_Module_Bootstrap
{
    /**
     * Imposta il routing prendendo dall'apposito file di configurazione.
     * Prima di tutto setta un nuovo router in modo da eliminare tutti i settaggi del modulo di default.
     */
    protected function _initRouting()
    {
        $ModuleConfig = new Zend_Config_Ini(APPLICATION_PATH . '/modules/' . strtolower($this->getModuleName()) . '/configs/routes.ini', 'production');
        $Router = Zend_Controller_Front::getInstance()->getRouter();

        $Router->addConfig($ModuleConfig, 'routes');
    }
}

?>