<?php

/**
 * @file library/Zwe/Controller/Router/Route.php
 * L'oggetto astratto che identifica le route.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 * @version     $Id: Route.php 139 2011-08-22 16:13:53Z flicofloc@gmail.com $
 */

/**
 * L'oggetto astratto che identifica le route.
 * Definisce i metodi di base, che poi andranno estesi nelle varie sottoclassi.
 *
 * @uses        Zend_Controller_Router_Route_Interface
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Router_Route
 */
abstract class Zwe_Controller_Router_Route implements Zend_Controller_Router_Route_Interface
{
    /**
     * La pagina associata al router
     *
     * @var Zwe_Model_Page
     */
    protected $_page;

    /**
     * Ritorna se una pagina è associata o meno a questo routing.
     *
     * @param string $path L'uri della pagina
     * @return array|bool I parametri della pagina o, nel caso non sia una pagina news, false
     */
    public function match($path)
    {
        $this->_page = Zwe_Model_Page::getThisPage($path);

        return $this->isMatching() ? $this->_defaults + $this->getParameters() : false;
    }

    /**
     * Identifica se la pagina è associata a questo routing o meno.
     * E' stato creato un metodo a se per poterlo estendere in ogni sottoclasse, mentre il metodo match() rimane invariato.
     *
     * @return bool
     */
    protected function isMatching()
    {
        return false;
    }

    /**
     * Ritorna i parametri associati alla pagina.
     * Deve essere riassegnata in ogni figlio in quanto i parametri sono tipi di ogni pagina.
     *
     * @return array
     */
    protected function getParameters()
    {
        if(empty($this->_page->Parameters))
            return array();

        return array('action' => array_shift($this->_page->Parameters));
    }

    /**
     * Recupera un'istanza di quest'oggetto.
     *
     * @static
     * @param Zend_Config $config
     * @return Un'istanza dell'oggetto
     */
    public static function getInstance(Zend_Config $config)
    {
        $frontController = Zend_Controller_Front::getInstance();

        $defs       = ($config->defaults instanceof Zend_Config) ? $config->defaults->toArray() : array();
        $dispatcher = $frontController->getDispatcher();
        $request    = $frontController->getRequest();

        /// @todo Da modificare con "new static()" appena mettono PHP 5.3
        $Backtrace = debug_backtrace();
        $Class = $Backtrace[1]['args'][0][0];
        return new $Class($defs, $dispatcher, $request);
    }

    /**
     * Il costruttore.
     * Si occupa di inizializzare i parametri di default, l'oggetto della request e del dispatcher.
     *
     * @param array $defaults
     * @param Zend_Controller_Dispatcher_Interface $dispatcher
     * @param Zend_Controller_Request_Abstract $request
     */
    public function __construct(array $defaults = array(), Zend_Controller_Dispatcher_Interface $dispatcher = null, Zend_Controller_Request_Abstract $request = null)
    {
        $this->_defaults = $defaults;

        if (isset($request))
            $this->_request = $request;

        if (isset($dispatcher))
            $this->_dispatcher = $dispatcher;
    }
}

?>