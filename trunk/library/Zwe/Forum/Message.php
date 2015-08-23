<?php

abstract class Zwe_Forum_Message extends Zwe_Model
{
    protected static $_alreadyFetched = array();

    protected $_name = 'forum';
    protected $_primary = 'IDForum';

    protected $_viewScript = null;

    protected $_parent = null;
    protected $_lastModify = null;
    protected $_author = null;

    public static function getForumById($ID, $DB = null)
    {
        if(array_key_exists($ID, self::$_alreadyFetched))
            return self::$_alreadyFetched[$ID];

        if(!isset($DB))
        {
            $Select = Zend_Db_Table::getDefaultAdapter()->select()->from('forum')->where("IDForum = '$ID'");
            $DB = Zend_Db_Table::getDefaultAdapter()->fetchRow($Select);
        }

        if($DB)
        {
            foreach(array('Forum', 'Post', 'Comment') as $Type)
            {
                $RetClass = 'Zwe_Forum_Message_' . $Type;
                $Ret = new $RetClass();

                $Ret->copyFromDb($DB);
                if($Ret->isOK())
                {
                    self::$_alreadyFetched[$ID] = $Ret;
                    return $Ret;
                }
            }
        }

        return null;
    }

    public abstract function isOK();

    public function getParent()
    {
        if(!isset($this->_parent))
            $this->_parent = self::getForumById($this->IDParent);

        return $this->_parent;
    }

    public function getLastModify()
    {
        if(!isset($this->_lastModify))
            $this->_lastModify = self::getForumById($this->IDLastModify);

        return $this->_lastModify;
    }

    public function getAuthor()
    {
        if(!isset($this->_author))
            $this->_author = Zwe_Model_User::getUserById($this->IDUser);

        return $this->_author;
    }

    public function printMessage()
    {
        return Zwe_Render::factory($this, array('viewScript' => 'forum/' . $this->_viewScript . '.phtml', 'scriptPath' => 'views/scripts/forum'))->render();
    }

    public function printExtended()
    {
        return Zwe_Render::factory($this, array('viewScript' => 'forum/' . $this->_viewScript . 'Extended.phtml', 'scriptPath' => 'views/scripts/forum'))->render();
    }

    public function __toString()
    {
        return $this->printMessage();
    }
}