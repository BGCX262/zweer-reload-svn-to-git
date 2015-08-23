<?php

class Zwe_Model_Photo extends Zwe_Model
{
    protected $_name = 'photo';
    protected $_primary = 'IDPhoto';

    public static function getPhotosByAlbum($IDAlbum)
    {
        $ThePhoto = new self();
        $Photos = $ThePhoto->fetchAll("IDParent = '$IDAlbum' AND Extension IS NOT NULL");
        $Ret = array();

        if($Photos)
        {
            foreach($Photos as $Photo)
            {
                $ThePhoto = new self();
                $Ret[] = $ThePhoto->copyFromDb($Photo);
            }
        }

        return $Ret;
    }

    public static function addPhoto($IDAlbum, $Title, $Extension)
    {
        $ThePhoto = new self();
        $Data = array('IDParent' => $IDAlbum, 'Title' => $Title, 'Extension' => $Extension, 'CreationDate' => new Zend_Db_Expr('NOW()'));

        return $ThePhoto->insert($Data);
    }
}

?>