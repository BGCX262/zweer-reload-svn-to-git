<?php

/**
 * @file library/Zwe/Controller/Action/Helper/LayoutLoader.php
 * Contiene la classe che gestisce il caricamento di un layout piuttosto che un altro.
 *
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Action_Helper
 * @version     $Id: LayoutLoader.php 12 2011-07-16 09:27:42Z flicofloc@gmail.com $
 */

/**
 * Gestisce il caricamento di un layout.
 * Il layout dipende dal modulo e deve essere inserito nel file di configurazione.
 *
 * @uses        Zend_Controller_Action_Helper_Abstract
 * @category    Zwe
 * @package     Zwe_Controller
 * @subpackage  Zwe_Controller_Action_Helper
 */
class Zwe_Controller_Action_Helper_LayoutLoader extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Imposta il layout appropriato.
     * Prima controlla che esista nel file di configurazione, quindi associa il layout in base al modulo.
     *
     * @return void
     */
	public function preDispatch()
	{
		$Bootstrap = $this->getActionController()->getInvokeArg('bootstrap');
		$Config = $Bootstrap->getOptions();
		$Module = $this->getRequest()->getModuleName();

		if(isset($Config[$Module]['resources']['layout']['layout']))
		{
			$LayoutScript = $Config[$Module]['resources']['layout']['layout'];
			$this->getActionController()->getHelper('layout')->setLayout($LayoutScript);
		}
	}
}

?>