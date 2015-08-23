<?php

class Zwe_Validate_Db_NoUrlExist extends Zend_Validate_Db_NoRecordExists
{
    protected $_messageTemplates = array(
        self::ERROR_RECORD_FOUND    => "There is already a page with url '%value%' child of the same parent",
    );

    public function __construct($IDParent = null, $IDPage = null)
    {
        parent::__construct(array('table' => 'page',
                                  'field' => 'url',
                                  'exclude' => (isset($IDParent) ? ("IDParent = '$IDParent'" . (isset($IDPage) ? " AND IDPage != '$IDPage'" : '')) : null)));
    }
}

?>