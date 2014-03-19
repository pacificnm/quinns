<?php
/**
 * City Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package City
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class City_SearchController extends Zend_Controller_Action
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
    	
    	$cityModel = new City_Model_City();
    	$results = $cityModel->loadByKeyword($keyword);
    	 
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }


}

