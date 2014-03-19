<?php

class Owner_SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * 
     */
    public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$keyword = $this->getParam('search');
    	
    	$ownerModel = new Owner_Model_Owner();
    	$results = $ownerModel->loadByKeyword($keyword);
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }


}

