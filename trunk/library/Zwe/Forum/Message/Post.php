<?php

class Zwe_Forum_Message_Post extends Zwe_Forum_Message
{
    const COMMENTS_LIMIT = 20;

    protected $_viewScript = 'post';

    public function isOK()
    {
        return $this->IsForum == 0 && $this->getParent()->IsForum == 1;
    }

    public function getComments($Start = 0, $Limit = self::COMMENTS_LIMIT)
    {
        $TheForum = new self();
        $Comments = $TheForum->fetchAll("IDParent = '" . $this->IDForum . "'", "Date", $Limit, $Start);
        $Ret = array();

        if($Comments)
        {
            foreach($Comments as $Comment)
            {
                $TheForum = new Zwe_Forum_Message_Comment();
                $TheForum->copyFromDb($Comment);

                $Ret[] = $TheForum;
            }
        }

        return $Ret;
    }
}