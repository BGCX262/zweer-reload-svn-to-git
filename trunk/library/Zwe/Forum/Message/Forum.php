<?php

class Zwe_Forum_Message_Forum extends Zwe_Forum_Message
{
    const POSTS_LIMIT = 20;

    protected $_viewScript = 'forum';

    public function isOK()
    {
        return $this->IsForum == 1;
    }

    public function getSubForums()
    {
        $TheForum = new self();
        $Forums = $TheForum->fetchAll("IDParent = '" . $this->IDForum . "' AND IsForum = '1'", "Position");
        $Ret = array();

        if($Forums)
        {
            foreach($Forums as $Forum)
            {
                $TheForum = new self();
                $TheForum->copyFromDb($Forum);

                $Ret[] = $TheForum;
            }
        }

        return $Ret;
    }

    public function getPosts($Start = 0, $Limit = self::POSTS_LIMIT)
    {
        $TheForum = new self();
        $Posts = $TheForum->fetchAll("IDParent = '" . $this->IDForum . "' AND IsForum = '0'", "DateLastModify", $Limit, $Start);
        $Ret = array();

        if($Posts)
        {
            foreach($Posts as $Post)
            {
                $TheForum = new Zwe_Forum_Message_Post();
                $TheForum->copyFromDb($Post);

                $Ret[] = $TheForum;
            }
        }

        return $Ret;
    }
}