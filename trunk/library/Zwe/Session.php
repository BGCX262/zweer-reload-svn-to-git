<?php

class Zwe_Session extends Zend_Session
{
    protected static $_namespaces = array();

    public static function get($namespace)
    {
        if(!isset(self::$_namespaces[$namespace]))
            self::$_namespaces[$namespace] = new Zend_Session_Namespace($namespace);

        return self::$_namespaces[$namespace];
    }
}