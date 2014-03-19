<?php
/**
 * Tank-size Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Tank-size
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class TankSize_SearchController extends Zend_Controller_Action
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
    	
    	$tankSizeModel = new TankSize_Model_TankSize();
    	$results = $tankSizeModel->loadByKeyword($keyword);
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }


}

