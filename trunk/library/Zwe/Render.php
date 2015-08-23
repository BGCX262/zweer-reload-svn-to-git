<?php

final class Zwe_Render
{
    const ZENDVIEW_ADAPTER = 'Zwe_Render_ZendView';
    const DEFAULT_ADAPTER = self::ZENDVIEW_ADAPTER;

    public static function factory($object, array $options = array())
    {
        if(!isset($options['renderer']))
            $options['renderer'] = self::DEFAULT_ADAPTER;

        if(!is_string($options['renderer']) || !strlen($options['renderer']))
            throw new Exception('Render name must be a string');

        $renderName = $options['renderer'];
        Zend_Loader::loadClass($renderName);

        return new $renderName($object, $options);
    }
}