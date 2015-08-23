<?php

class Zwe_Model_Page_Gallery extends Zwe_Model_Page
{
    protected $_albums = array();

    public static function getGalleryPages($Tree = false)
    {
        return self::getPagesByType('Gallery', $Tree);
    }

    protected function specificPageInit()
    {
        $this->_albums = Zwe_Model_Album::getPageAlbums($this->IDPage);
    }

    public function __get($Name)
    {
        if('Albums' == $Name)
            return $this->_albums;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('Albums' == $Name)
        {
            if(is_array($Value))
                $this->_albums = $Value;
            else
                throw new Exception('$Value must be an array');
        }
        else
            parent::__set($Name, $Value);
    }
}

?>