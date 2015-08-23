<?php

/**
 * @file library/Zwe/Model/Page/Login.php
 * Il modello per la pagina di login.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_Page
 * @version     $Id: Login.php 97 2011-07-29 17:09:15Z flicofloc@gmail.com $
 */

/**
 * Il modello per la pagina di login.
 * E' una pagina fissa, quindi non può pescare le informazioni dal database.
 * Per compatibilità queste informazioni vengono passate a mano.
 *
 * @uses        Zwe_Model_Page
 * @category    Zwe
 * @package     Zwe_Model
 * @subpackage  Zwe_Model_page
 */
class Zwe_Model_Page_Login extends Zwe_Model_Page
{
    /**
     * L'uri della pagina di login.
     *
     * @var string
     */
    const LOGIN_URL = '/login';

    /**
     * L'uri della pagina di logout.
     *
     * @var string
     */
    const LOGOUT_URL = '/login/logout';

    /**
     * Il costruttore dell'oggetto.
     * Richiama il metodo padre e per compatibilità assegna il titolo alla pagina
     *
     * @param array $config L'array di configurazione, passato sempre per compatibilità
     */
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->Title = 'Login';
    }
}

?>