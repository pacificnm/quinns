<?php
/**
 * Filtration Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Filtration
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Filtration_SearchController extends Zend_Controller_Action
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
    	 
    	$filtrationModel = new Filtration_Model_Filtration();
    	$results = $filtrationModel->loadByKeyword($keyword);
    	
    	 
    	echo Zend_Json::encode($results);
    	 
    	exit();
    }


}

