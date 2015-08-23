<?php

class Admin_View_Helper_PrintUlGalleryPages extends Zwe_View_Helper_PrintUlChildren
{
    public function printUlGalleryPages(array $Tree, $Id = null)
    {
        return $this->printUlChildren($Tree, $Id);
    }

    protected function getChildren($Leaf)
    {
        return $Leaf->Albums;
    }

    protected function getChildId($Child)
    {
        return $Child->IDPhoto;
    }

    protected function getChildEdit($Child)
    {
        return '<a href="' . $this->view->url(array('album' => $Child->IDAlbum), 'albumEdit') . '">' . $this->view->import_Img('icons/edit_16x16.png', array('alt' => '[M]', 'title' => 'Edit the album')) . '</a>';
    }

    protected function getChildDelete($Child)
    {
        return '<a href="' . $this->view->url(array('album' => $Child->IDAlbum), 'albumDelete') . '">' . $this->view->import_Img('icons/delete_16x16.png', array('alt' => '[X]', 'title' => 'Delete the album')) . '</a>';
    }

    protected function getChildOther($Child)
    {
        return '<a href="' . $this->view->url(array('album' => $Child->IDAlbum), 'photo') . '">' . $this->view->import_Img('icons/picture_16x16.png', array('alt' => '[UP]', 'title' => 'Manage photos')) . '</a>';
    }
}

?>