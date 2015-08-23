<?php

/**
 * @file library/Zwe/Model/News.php
 * Il modello delle news.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @version     $Id: News.php 158 2011-09-01 16:09:08Z flicofloc@gmail.com $
 */

/**
 * Il modello delle news.
 *
 * @uses        Zwe_Model
 * @category    Zwe
 * @package     Zwe_Model
 */
class Zwe_Model_News extends Zwe_Model
{
    protected $_name = 'news';
    protected $_primary = 'IDNews';

    protected $_author = null;

    /**
     * Ritorna le news di una determinata pagina.
     * Se non sono presenti ritorna un array vuoto.
     *
     * @static
     * @param int $IDPage L'identificativo della pagina di cui si vogliono estrarre le news
     * @param int $Count
     * @param int $Offset
     *
     * @return array
     */
    public static function getPageNews($IDPage, $Count = null, $Offset = null)
    {
        $Ret = array();
        $N = new self();

        $News = $N->fetchAll("IDPage = '$IDPage' AND IsComment = '0'", 'Date DESC', $Count, $Offset);

        if($News)
        {
            foreach($News as $New)
            {
                $N = new self();
                $N->copyFromDb($New);
                $N->Author = Zwe_Model_User::getUserById($N->IDAuthor);
                $Ret[] = $N;
            }
        }

        return $Ret;
    }

    public static function getNewsByID($IDNews)
    {
        $News = new self();
        $News->fetchRowAndSet("IDNews = '$IDNews'");
        $News->Author = Zwe_Model_User::getUserById($News->IDAuthor);

        return $News;
    }

    public static function addNews($Title, $IDPage, $Text)
    {
        $News = new self();
        $Data = array('Title' => $Title, 'IDPage' => $IDPage, 'Text' => $Text, 'IDAuthor' => Zend_Auth::getInstance()->getIdentity()->IDUser, 'Date' => new Zend_Db_Expr('NOW()'));

        return $News->insert($Data);
    }

    public static function editNews($IDNews, $Title, $IDPage, $Text)
    {
        $News = new self();
        $Data = array('Title' => $Title, 'IDPage' => $IDPage, 'Text' => $Text);

        return $News->update($Data, "IDNews = '$IDNews'");
    }

    public static function deleteNews($IDNews)
    {
        $News = new self();

        return $News->delete("IDNews = '$IDNews'");
    }

    public static function parentNews($IDNews, $IDPage)
    {
        $News = new self();
        $Data = array('IDPage' => $IDPage);

        return $News->update($Data, "IDNews = '$IDNews'");
    }

    public function toForm()
    {
        return array('title' => $this->Title,
                     'page' => $this->IDPage,
                     'text' => $this->Text,
                     'id' => $this->IDNews);
    }

    public function __get($Name)
    {
        if('Author' == $Name)
            return $this->_author;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('Author' == $Name)
        {
            if($Value instanceof Zwe_Model_User)
                $this->_author = $Value;
            else
                throw new Exception('$value is not the expected value');
        }
        else
            parent::__set($Name, $Value);
    }
}

?>