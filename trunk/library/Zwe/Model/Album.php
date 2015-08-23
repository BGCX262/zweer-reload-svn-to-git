<?php

class Zwe_Model_Album extends Zwe_Model
{
    protected $_name = 'photo';
    protected $_primary = 'IDPhoto';

    protected $_photos = null;

    public static function getPageAlbums($IDPage)
    {
        $Ret = array();
        $A = new self();
        $Albums = $A->fetchAll("IDParent = '$IDPage' AND Extension IS NULL", 'Title');

        if($Albums)
        {
            foreach($Albums as $Album)
            {
                $A = new self();
                $Ret[] = $A->copyFromDb($Album);
            }
        }

        return $Ret;
    }

    public static function getAlbumByID($IDAlbum)
    {
        $Album = new self();

        return $Album->fetchRowAndSet("IDPhoto = '$IDAlbum' AND Extension IS NULL");
    }

    public static function addAlbum($Title, $IDPage, $Description)
    {
        $Album = new self();
        $Data = array('Title' => $Title, 'IDParent' => $IDPage, 'Description' => $Description);

        return $Album->insert($Data);
    }

    public static function editAlbum($IDAlbum, $Title, $IDPage, $Description)
    {
        $Album = new self();
        $Data = array('Title' => $Title, 'IDParent' => $IDPage, 'Description' => $Description, 'CreationDate' => new Zend_Db_Expr('NOW()'));

        return $Album->update($Data, "IDPhoto = '$IDAlbum' AND Extension IS NULL");
    }

    public static function deleteAlbum($IDAlbum)
    {
        $Album = new self();

        return $Album->delete("IDPhoto = '$IDAlbum' AND Extension IS NULL");
    }

    public static function parentAlbum($IDAlbum, $IDPage)
    {
        $Album = new self();
        $Data = array('IDParent' => $IDPage);

        return $Album->update($Data, "IDPhoto = '$IDAlbum' AND Extension IS NULL");
    }

    public function getPhotos()
    {
        if(!isset($this->_photos))
            $this->_photos = Zwe_Model_Photo::getPhotosByAlbum($this->IDAlbum);

        return $this->_photos;
    }

    public function toForm()
    {
        return array('title' => $this->Title,
                     'page' => $this->IDParent,
                     'description' => $this->Description,
                     'id' => $this->IDAlbum);
    }

    public function __get($Name)
    {
        if('IDAlbum' == $Name)
            return $this->IDPhoto;
        elseif('Photos' == $Name)
            return $this->getPhotos();
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('IDAlbum' == $Name)
            $this->IDPhoto = $Value;
        else
            parent::__set($Name, $Value);
    }
}

?>