<?php
/**
 * Tank-model Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package TankModel
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class TankModel_SearchController extends Zend_Controller_Action
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
    	 
    	$tankModel = new TankModel_Model_TankModel();
    	$results = $tankModel->loadByKeyword($keyword);
    	 
    	echo Zend_Json::encode($results);
    	 
    	exit();
    }


}

