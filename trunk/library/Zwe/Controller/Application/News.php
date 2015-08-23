<?php

/**
 * @file application/controllers/NewsController.php
 * Il controller delle news
 *
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @version     $Id: News.php 141 2011-08-22 16:53:32Z flicofloc@gmail.com $
 */

/**
 * Controller che gestisce le pagine delle news.
 *
 * @uses        Zwe_Controller_Action_Default
 * @category    application
 * @package     Default
 * @subpackage  Controller
 * @todo        Gestire la possibilità di avere più pagine di news.
 * @todo        Gestire i link statici, ovvero la pagina propria di una news, con un url esplicito e "motore di ricerca"-style.
 * @todo        Gestire la possibilità di commentare le news, in modo che diventi come un blog.
 * @todo        Gestire l'html nelle news.
 * @todo        Aggiungere il context switch per l'rss
 */
class Zwe_Controller_Application_News extends Zwe_Controller_Action_Default
{
    /**
     * Inizializza il controller.
     * Non fa nulla se non richiamare l'inizializzatore del padre.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * L'action di base.
     * Non introduce alcuna logica.
     */
    public function indexAction()
    {
        
    }
}

?>