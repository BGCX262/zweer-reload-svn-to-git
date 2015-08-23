<?php

class Zwe_Calendar_Render_ZendView extends Zwe_Calendar_Render_Abstract implements Zwe_Calendar_Render_Interface
{
    protected $_defaultOptions = array('viewScript' => 'calendar.phtml',
                                       'scriptPath' => 'application/views/scripts/calendar');

    public function render()
    {
        $view = clone Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->clearVars();
        $view->calendar = $this->getCalendar();
        $view->addScriptPath(dirname(APPLICATION_PATH) . '/' . $this->_options['scriptPath']);

        return $view->render($this->_options['viewScript']);
    }
}

?>