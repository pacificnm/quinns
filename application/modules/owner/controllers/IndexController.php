<?php

class Owner_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$page = $this->_request->getParam('page');
    	
    	$locationId = $this->getParam('location_id');
    	$this->view->locationId = $locationId;
    	
    	if($locationId) {
    		$locationModel = new Location_Model_Location();
    		$location = $locationModel->loadById($locationId);
    		$this->view->location = $location;
    	}
    	
    	if ($this->getRequest()->isPost()) {
    		$ownerModel = new Owner_Model_Owner();
    		$keyword = $this->getParam('owner');
    		
    		$this->view->keyword = $keyword;
    		
    		$owners = $ownerModel->loadByName($keyword, $page);
    		$this->view->owners = $owners;
    		
    		
    		
    		/**
    		if(empty($owner)) {
    			$this->redirect('/owner/add/index/name/'.urlencode($keyword).'/msg/not-found');
    		} else {
    			$this->redirect('/owner/view/index/id/'.$owner->id);
    		}
    		*/
    	}
    }


}

