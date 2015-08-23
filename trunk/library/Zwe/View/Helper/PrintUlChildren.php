<?php

class Zwe_View_Helper_PrintUlChildren extends Zend_View_Helper_Abstract
{
    protected $_class = 'movable_children_list';

    public function printUlChildren(array $Tree, $Id = null)
    {
        if(!isset($Id))
            $Id = $this->_class;

        if(count($Tree) == 0)
            return '';

        $Ret  = '<ul class="' . $this->_class . '" id="' . $Id . '">';

        foreach($Tree as $Leaf)
        {
            $Ret .= '<li class="' . $this->_class . '_parent" id="' . $Id . '_parent_' . $this->getId($Leaf) . '">';

            $Ret .= $this->getExpander($Leaf);

            $Ret .= $this->getTitle($Leaf);

            $Ret .= $this->printChildren($this->getChildren($Leaf), $Id);
            $Ret .= '</li>';
        }

        $Ret .= '</ul>';
        return $Ret;
    }

    protected function printChildren($Children, $Id)
    {
        if(count($Children) == 0)
            return '';

        $Ret  = '<ul class="' . $this->_class . '_children">';

        foreach($Children as $Child)
        {
            $Ret .= '<li class="' . $this->_class . '_child" id="' . $Id . '_child_' . $this->getChildId($Child) . '">';

            $Ret .= $this->getExpander($Child);

            $Ret .= $this->getChildTitle($Child);
            $Ret .= $this->getChildEdit($Child);
            $Ret .= $this->getChildDelete($Child);
            $Ret .= $this->getChildOther($Child);

            $Ret .= '</li>';
        }

        $Ret .= '</ul>';
        return $Ret;
    }

    protected function getId($Leaf)
    {
        return $Leaf->IDPage;
    }

    protected function getTitle($Leaf)
    {
        return $Leaf->Title;
    }

    protected function getChildren($Leaf)
    {
        return array();
    }

    protected function getExpander($Leaf)
    {
        return '<a href="#" class="mover"></a>';
    }

    protected function getChildId($Child)
    {
        return '';
    }

    protected function getChildTitle($Child)
    {
        return $Child->Title;
    }

    protected function getChildEdit($Child)
    {
        return '';
    }

    protected function getChildDelete($Child)
    {
        return '';
    }

    protected function getChildOther($Child)
    {
        return '';
    }
}

?>