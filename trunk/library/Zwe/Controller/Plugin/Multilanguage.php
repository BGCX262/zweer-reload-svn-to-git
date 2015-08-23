<?php

class Zwe_Controller_Plugin_Multilanguage extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        if (substr($request->getRequestUri(), 0, -1) == $request->getBaseUrl()){
            $request->setRequestUri($request->getRequestUri() . Zend_Registry::get('parameters')->registry->defaultlanguage . "/");
            $request->setParam("language", Zend_Registry::get('parameters')->registry->defaultlanguage);
        }
    }

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $language =  $request->getParam("language", Zend_Registry::get('Zend_Locale')->getLanguage());
        $locale = new Zend_Locale($language);
        Zend_Registry::get('Zend_Locale')->setLocale($locale);
        $translate = Zend_Registry::get('Zend_Translate');
        $translate->getAdapter()->setLocale(Zend_Registry::get('Zend_Locale'));
        Zend_Controller_Router_Route::setDefaultTranslator($translate);
    }
}