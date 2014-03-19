<?php
/**
 * Tank-type Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Tank-type
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class TankType_SearchController extends Zend_Controller_Action
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
    	
    	$tankTypeModel = new TankType_Model_TankType();
    	$results = $tankTypeModel->loadByKeyword($keyword);
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }


}

