<?php

class Admin_View_Helper_PrintUlPages extends Zwe_View_Helper_PrintUl
{
    public function printUlPages(array $Tree)
    {
        return $this->printUl($Tree);
    }

    protected function getEdit($Leaf)
    {
        return '<a href="' . $this->view->url(array('page' => $Leaf['IDPage']), 'pagesEdit') . '">' . $this->view->import_Img('icons/edit_16x16.png', array('alt' => '[M]', 'title' => 'Edit the page')) . '</a>';
    }

    protected function getDelete($Leaf)
    {
        return '<a href="' . $this->view->url(array('page' => $Leaf['IDPage']), 'pagesDelete') . '">' . $this->view->import_Img('icons/delete_16x16.png', array('alt' => '[X]', 'title' => 'Delete the page')) . '</a>';
    }
}

?>