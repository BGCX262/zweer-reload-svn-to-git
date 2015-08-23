<?php

/**
 * @file public/index.php
 * E' il file da cui parte l'applicazione.
 * Setta le variabili principali e quindi fa partire l'applicazione.
 *
 * @category    Site
 * @package     Index
 * @version     $Id: index.php 129 2011-08-21 08:21:31Z flicofloc@gmail.com $
 */

/**
 * Definisce il path dell'applicazione.
 * Corrisponde a /application
 */
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

/**
 * Definisce il path della cartella temporanea.
 * Corrisponde a /temp
 */
defined('TEMP_PATH') || define('TEMP_PATH', realpath(dirname(__FILE__) . '/../temp'));

/**
 * Definisce il path dei file pubblici (css, js e immagini)
 * Corrisponde a /public
 */
defined('PUBLIC_PATH') || define('PUBLIC_PATH', dirname(__FILE__));

/**
 * Definisce l'ambiente di sviluppo.
 * Lo va a prendere direttamente dalle configurazioni del server (quindi dal file .htaccess).
 * Se non lo trova lo imposta di default a "production".
 */
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
 * Imposta il path per le inclusioni.
 * Aggiunge a quanto già presente la cartella /library
 */
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/../library'), get_include_path())));

/**
 * @uses        Zend/Application.php
 */
require_once 'Zend/Application.php';

/**
 * Crea l'applicazione e la fa partire.
 * Inserisce come file di configurazione /application/configs/application.ini
 */
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap()->run();

?>