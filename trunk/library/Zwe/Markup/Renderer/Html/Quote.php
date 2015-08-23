<?php

class Zwe_Markup_Renderer_Html_Quote extends Zend_Markup_Renderer_Html_HtmlAbstract
{
    const ATTRIBUTE_USER = 'user';
    const TOKEN_WROTE = 'ZweMarkupRenderTokenWrote';

    protected $_token_wrote = array(self::TOKEN_WROTE => 'wrote');

    public function convert(Zend_Markup_Token $token, $text)
    {
        $user = '';
        if($token->hasAttribute(self::ATTRIBUTE_USER))
        {
            $user = $token->getAttribute(self::ATTRIBUTE_USER);
            $wrote = $this->_token_wrote[self::TOKEN_WROTE];

            if(Zend_Registry::isRegistered('Zend_Translate'))
            {
                $translator = Zend_Registry::get('Zend_Translate');
                if($translator->isTranslated(self::TOKEN_WROTE))
                    $wrote = $translator->translate(self::TOKEN_WROTE);
                else
                    $wrote = $translator->translate($wrote);
            }

            $user = '<div class="quote_author">' . $user . ' ' . $wrote . ':</div>';
        }

        return "<blockquote>{$user}{$text}</blockquote>";
    }
}