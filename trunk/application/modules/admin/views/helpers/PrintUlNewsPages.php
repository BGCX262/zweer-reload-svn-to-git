<?php

class Admin_View_Helper_PrintUlNewsPages extends Zwe_View_Helper_PrintUlChildren
{
    public function printUlNewsPages(array $Tree, $Id = null)
    {
        return parent::printUlChildren($Tree, $Id);
    }

    protected function getChildren($Leaf)
    {
        return $Leaf->News;
    }

    protected function getChildId($Child)
    {
        return $Child->IDNews;
    }

    protected function getChildEdit($Child)
    {
        return '<a href="' . $this->view->url(array('news' => $Child->IDNews), 'newsEdit') . '">' . $this->view->import_Img('icons/edit_16x16.png', array('alt' => '[M]', 'title' => 'Edit the news')) . '</a>';
    }

    protected function getChildDelete($Child)
    {
        return '<a href="' . $this->view->url(array('news' => $Child->IDNews), 'newsDelete') . '">' . $this->view->import_Img('icons/delete_16x16.png', array('alt' => '[X]', 'title' => 'Delete the news')) . '</a>';
    }
}

?>