<?php

class Owner_AddController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $locationId = (int)$this->getParam('location_id');
       
        // load location
        $locationModel = new Location_Model_Location();
        $location = $locationModel->loadById($locationId);
        $this->view->location = $location;
        
        $name = ucwords(strtolower(urldecode($this->getParam('name'))));
        
        $formModel = new Owner_Form_Add();
        
        if(!empty($location)) {
        	$form = $formModel->owner($name,$location->street,$location->city,$location->state,$location->zip);
        } else {
        	$form = $formModel->owner($name,'','','','');
        }
        
        
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($this->getRequest()->getPost())) {
        		 
        		$name = $this->getParam('name');
        		$street = $this->getParam('street');
        		$street2 = $this->getParam('street2');
        		$city = $this->getParam('city');
        		$state = $this->getParam('state');
        		$zip = $this->getParam('zip');
        		$email = $this->getParam('email');
        		$phone = $this->getParam('phone');
        		$ownerType = $this->getParam('owner_type');
        		
        		$ownerModel = new Owner_Model_Owner();
        		$ownerId = $ownerModel->create($name, $street, $street2, $city, $state, $zip, $phone, $email, 1);
        		
        		if($locationId) {
	        		// map location
	        		$ownerLocationModel = new Owner_Model_OwnerLocation();
	        		$ownerLocationModel->create($locationId, $ownerId, $ownerType, 1);
	        		
        			$this->redirect('/location/view/index/id/' . $locationId.'/msg/location-add');
        		} else {
        			$this->redirect('/owner/view/index/id/' . $ownerId);
        		}
        	} else {
        		$form->highlightErrorElements();
        	}
        }
        
        
        
        
        $this->view->form = $form;
    }

    public function locationAction()
    {
    	
    	$ownerId = $this->getParam('owner_id');
    	if($ownerId < 1) {
    		$this->redirect('/owner/add/error/msg/no-owner_id');
    	}
    	
    	$ownerModel = new Owner_Model_Owner();
    	$owner = $ownerModel->loadById($ownerId);
    	if(empty($owner)) {
    		Zend_Debug::dump($this->getAllParams());
    		die;	
    		$this->redirect('/owner/add/error/no-owner');
    	}
    	
    	$locationId = $this->getParam('location_id');
    	if($locationId < 1) {
    		$this->redirect('/owner/add/error/no-location');
    	}
    	
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($locationId);
    	
    	if(empty($location)){
    		$this->redirect('/owner/add/error/no-location');
    	}
    	
    	$ownerType = $this->getParam('owner_type');
    	if(empty($ownerType)) {
    		$ownerType = 'Owner';
    	}
    	
    	$ownerLocationModel = new Owner_Model_OwnerLocation();
    	$ownerLocationModel->create($locationId, $ownerId, $ownerType, 1);
    
    	
    	$this->redirect('/location/view/index/id/' . $locationId);
    	
    }

}

