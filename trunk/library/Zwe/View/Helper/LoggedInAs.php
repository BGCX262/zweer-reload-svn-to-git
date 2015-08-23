<?php

/**
 * @file library/Zwe/View/Helper/LoggedInAs.php
 * L'helper che gestisce il riquadro della login.
 *
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper
 * @version     $Id: LoggedInAs.php 48 2011-07-24 11:47:37Z flicofloc@gmail.com $
 */

/**
 * L'helper che gestisce il riquadro della login.
 * Se un utente è già loggato visualizza il link ai messaggi, alla parte admin e al logout.
 * Se un utente non è ancora loggato, visualizza il link alla login.
 * Per poter essere esteso facilmente ogni link è ritornato da un metodo a sè, così se ne può cambiare uno solo senza riscrivere tutta la classe.
 *
 * @uses        Zend_View_Helper_Abstract
 * @category    Zwe
 * @package     Zwe_View
 * @subpackage  Zwe_View_Helper
 */
class Zwe_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{
    /**
     * L'uri a cui far arrivare l'utente dopo che esce dalla parte admin.
     *
     * @var string
     */
    const PUBLIC_URL = '/';
    /**
     * L'uri a cui far arrivare l'utente quando vuole entrare nella parte admin.
     *
     * @var string
     */
    const ADMIN_URL = '/admin';

    /**
     * Ritorna una stringa con l'html del riquadro della login, con i link.
     *
     * @return string
     */
    public function loggedInAs()
    {
        $Auth = Zend_Auth::getInstance();
        $Ret = '';

        if($Auth->hasIdentity())
        {
            $IsAdmin = Zend_Controller_Front::getInstance()->getRequest()->getModuleName() == 'admin';

            $Ret .= '<a href="' . Zwe_Model_Page_Messages::MESSAGES_URL . '">' . $this->getMessagesText() . '</a> ';
            $Ret .= '<a href="' . ($IsAdmin ? self::PUBLIC_URL : self::ADMIN_URL) . '">' . ($IsAdmin ? $this->getPublicText() : $this->getAdminText()) . '</a> ';
            $Ret .= '<a href="' . Zwe_Model_Page_Login::LOGOUT_URL . '">' . $this->getLogoutText() . '</a> ';
        }
        else
        {
            $Ret .= '<a href="' . Zwe_Model_Page_Login::LOGIN_URL . '">' . $this->getLoginText() . '</a>';
        }

        return $Ret;
    }

    /**
     * Ritorna l'html del testo per il link di login.
     *
     * @return string
     */
    protected function getLoginText()
    {
        return $this->view->import_Img('icons/unlock_24x24.png', array('title' => 'Login', 'alt' => 'Login'));
    }

    /**
     * Ritorna l'html del testo per il link di logout.
     *
     * @return string
     */
    protected function getLogoutText()
    {
        return $this->view->import_Img('icons/lock_24x24.png', array('title' => 'Logout', 'alt' => 'Logout'));
    }

    /**
     * Ritorna l'html del testo per il link ai messaggi.
     *
     * @return string
     */
    protected function getMessagesText()
    {
        return $this->view->import_Img('icons/mail_24x24.png', array('title' => 'Messages', 'alt' => 'Messages'));
    }

    /**
     * Ritorna l'html del testo per il link alla parte pubblica.
     *
     * @return string
     */
    private function getPublicText()
    {
        return $this->view->import_Img('icons/magic_wand_24x24.png', array('title' => 'Public', 'alt' => 'Public'));
    }

    /**
     * Ritorna l'html del testo per il link alla parte admin.
     *
     * @return string
     */
    private function getAdminText()
    {
        return $this->view->import_Img('icons/wrench_24x24.png', array('title' => 'Admin', 'alt' => 'Admin'));
    }
}

?>