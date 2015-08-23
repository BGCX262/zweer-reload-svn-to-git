<?php

final class Zwe_Calendar_Render
{
    const ZENDVIEW_ADAPTER = 'ZendView';
    const DEFAULT_ADAPTER = self::ZENDVIEW_ADAPTER;

    /**
     * Ritorna il render richiesto tramite le opzioni.
     *
     * @static
     * @throws Exception
     * @param Zwe_Calendar $calendar
     * @param array $options
     * @return Zwe_Calendar_Render_Abstract
     */
    public static function factory(Zwe_Calendar $calendar, array $options = array())
    {
        if(!isset($options['renderer']))
            $options['renderer'] = self::DEFAULT_ADAPTER;

        if(!is_string($options['renderer']) || !strlen($options['renderer']))
            throw new Exception('Render name must be a string');

        $rendererName = 'Zwe_Calendar_Render_' . $options['renderer'];
        Zend_Loader::loadClass($rendererName);

        return new $rendererName($calendar, $options);
    }
}

?>