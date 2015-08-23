<?php

/**
 * @file library/Zwe/Controller/Action.php
 * Classe astratta per le action.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @version     $Id: Action.php 160 2011-09-02 16:33:02Z flicofloc@gmail.com $
 */

/**
 * Classe astratta per le action.
 * Si occupa di definire azioni di default come la memorizzazione della pagina e del titolo.
 *
 * @uses        Zend_Controller_Action
 * @category    Zwe
 * @package     Zwe_Controller
 */
abstract class Zwe_Controller_Action extends Zend_Controller_Action
{
    public $contexts = null;

    protected $_context = null;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->_helper->addPath('Zwe/Controller/Action/Helper', 'Zwe_Controller_Action_Helper');
        $this->initContext();
    }

    public function initContext()
    {
        if(isset($this->contexts))
        {
            $this->_helper->contextSwitch->initContext();
            $this->_context = $this->_helper->contextSwitch->getCurrentContext();
        }
    }

    public function postDispatch()
    {
        if(isset($this->_context))
            $this->_helper->layout->disableLayout();
    }
}

?>