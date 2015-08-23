<?php

class Zwe_Markup_Bbcode
{
    /**
     * @var Zend_Markup_Renderer_RendererAbstract
     */
    protected static $_instance = null;

    public static function getInstance($renderer = 'Html', array $options = array())
    {
        if(!isset(self::$_instance))
            self::$_instance = self::_getInstance($renderer, $options);

        return self::$_instance;
    }

    protected static function _getInstance($renderer = 'Html', array $options = array())
    {
        $BBCode = Zend_Markup::factory('Bbcode', $renderer, $options);

        $BBCode->removeMarkup('quote');
        $BBCode->addMarkup('quote',
                           Zend_Markup_Renderer_RendererAbstract::TYPE_CALLBACK,
                           array('callback' => new Zwe_Markup_Renderer_Html_Quote(),
                                 'group' => 'block'));

        return $BBCode;
    }
}