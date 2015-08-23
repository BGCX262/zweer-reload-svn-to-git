<?php

class Zwe_Render_ZendView extends Zwe_Render_Abstract implements Zwe_Render_Interface
{
    protected $_defaultOptions = array('viewScript' => '',
                                       'scriptPath' => 'views/scripts');

    public function render()
    {
        $view = clone Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->clearVars();
        $view->object = $this->getObject();
        $view->addScriptPath(APPLICATION_PATH . '/' . $this->_options['scriptPath']);

        return $view->render($this->_options['viewScript']);
    }
}