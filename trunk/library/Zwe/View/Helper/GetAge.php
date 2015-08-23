<?php

class Zwe_View_Helper_GetAge extends Zend_View_Helper_Abstract
{
    public function getAge($Birth, $Death = null)
    {
        $Birth = new Zend_Date($Birth);

        if(!isset($Death))
            $Death = new Zend_Date();
        $Death = new Zend_Date($Death);

        $DeltaYears = $Death->get(Zend_Date::YEAR) - $Birth->get(Zend_Date::YEAR);
        $DeltaMonths = $Death->get(Zend_Date::MONTH) - $Birth->get(Zend_Date::MONTH);
        $DeltaDays = $Death->get(Zend_Date::DAY) - $Birth->get(Zend_Date::DAY);

        if($DeltaMonths < 0)
            $DeltaYears--;
        elseif(0 == $DeltaMonths && $DeltaDays < 0)
            $DeltaYears--;

        return $DeltaYears;
    }
}