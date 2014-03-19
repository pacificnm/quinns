<?php
/**
 * State Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package State
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class State_SearchController extends Zend_Controller_Action
{

    /**
     * Init
     */
    public function init()
    {
    }

    /**
     * indexAction
     */
    public function indexAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$keyword = $this->getParam('search');
    	 
    	$stateModel = new State_Model_State();
    	$results = $stateModel->loadByKeyword($keyword);
    	
    	 
    	echo Zend_Json::encode($results);
    	 
    	exit();
    }


}

