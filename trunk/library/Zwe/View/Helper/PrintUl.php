<?php

class Zwe_View_Helper_PrintUl extends Zend_View_Helper_Abstract
{
    protected $_class = 'movable_list';

    public function printUl(array $Tree, $Id = null, $Mover = true, $Depth = 0)
    {
        if(!isset($Id))
            $Id = $this->_class;

        if(count($Tree) == 0)
            return '';

        $Ret  = '<ul' . ($Depth == 0 ? ' class="' . $this->_class . '" id="' . $Id . '"' : '') . '>';

        foreach($Tree as $Leaf)
        {
            $Ret .= '<li id="' . $Id . '_' . $this->getId($Leaf) . '">';
            
            if($Mover)
                $Ret .= $this->getMover($Leaf);

            $Ret .= $this->getTitle($Leaf);
            $Ret .= $this->getEdit($Leaf);
            $Ret .= $this->getDelete($Leaf);
            $Ret .= $this->getOther($Leaf);

            $Ret .= $this->printUl($this->getChild($Leaf), $Id, $Mover, ++$Depth);
            $Ret .= '</li>';
        }

        $Ret .= '</ul>';
        return $Ret;
    }

    protected function getId($Leaf)
    {
        return $Leaf['IDPage'];
    }

    protected function getMover($Leaf)
    {
        return '<a href="#" class="mover"></a>';
    }

    protected function getTitle($Leaf)
    {
        return $Leaf['Title'];
    }

    protected function getChild($Leaf)
    {
        return $Leaf['Child'];
    }

    protected function getEdit($Leaf)
    {
        return '';
    }

    protected function getDelete($Leaf)
    {
        return '';
    }

    protected function getOther($Leaf)
    {
        return '';
    }
}

?>