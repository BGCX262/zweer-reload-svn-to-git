<?php

/**
 * @file application/Bootstrap.php
 * Contiene la classe di Bootstrap per inizializzare l'applicazione.
 *
 * @category    application
 * @package     Default
 * @subpackage  Bootstrap
 * @version     $Id: Bootstrap.php 167 2011-10-19 16:17:53Z flicofloc@gmail.com $
 */

/**
 * Gestisce l'inizializzazione dell'applicazione.
 * Fa partire tutte le funzioni "_init" in modo da applicare tutti i settaggi necessari per l'esecuzione dell'applicazione.
 *
 * @uses        Zend_Application_Bootstrap_Bootstrap
 * @category    Site
 * @package     Default
 * @subpackage  Bootstrap
 */
class Zwe_Application_Bootstrap_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initStripSlashes()
    {
        if(get_magic_quotes_gpc())
        {
            function stripslashes_gpc(&$Value)
            {
                $Value = stripslashes($Value);
            }

            $GPC = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
            array_walk_recursive($GPC, 'stripslashes_gpc');
        }
    }

    /**
     * Imposta l'auto-load per le classi della libreria Zwe.
     *
     * @return Zend_Application_Module_Autoloader
     */
	protected function _initAppAutoload()
	{
		$Autoloader = new Zend_Application_Module_Autoloader(array('namespace' => 'App',
			                                                       'basePath' => APPLICATION_PATH));
		$Autoloader->addResourceType('zwe', dirname(APPLICATION_PATH) . '/library/Zwe', 'Zwe');

		return $Autoloader;
	}

    /**
     * Memorizzo i parametri del sito dal file di configurazione.
     *
     * @return Zend_Config_Ini
     */
    protected function _initParameters()
    {
        $Config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/parameters.ini');
        Zend_Registry::set('parameters', $Config);

        return $Config;
    }

    protected function _initTranslate()
    {
        Zend_Registry::set('Zend_Translate', new Zend_Translate('array', realpath(APPLICATION_PATH . '/../language'), Zend_Registry::get('parameters')->registry->defaultLanguage, array('scan' => Zend_Translate::LOCALE_DIRECTORY)));
        Zend_Registry::set('Zend_Locale', new Zend_Locale());
    }

    /**
     * Inizializza i parametri della view.
     * Imposta i seguenti parametri:
     * - il path dove reperire gli helper;
     * - il charset del sito (indispensabile per gli accenti)
     * - il titolo del sito, con relativo separatore
     */
	protected function _initMyView()
	{
		$this->_bootstrap('view');
		$View = $this->getResource('view');

		$View->addHelperPath('Zwe/View/Helper', 'Zwe_View_Helper');

        $View->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');

        $View->headTitle(Zend_Registry::get('parameters')->registry->siteTitle)->setSeparator(' :: ');
	}

    /**
     * Decide il layout, se default o admin.
     */
	protected function _initLayoutHelper()
	{
		$this->bootstrap('frontController');
		Zend_Controller_Action_HelperBroker::addHelper(new Zwe_Controller_Action_Helper_LayoutLoader());
	}

    /**
     * Imposta il routing prendendo dall'apposito file di configurazione.
     */
    protected function _initRouting()
    {
        $Config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
        $Router = Zend_Controller_Front::getInstance()->getRouter();

        $Router->addConfig($Config, 'routes');
    }
}

