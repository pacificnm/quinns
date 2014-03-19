<?php

class Owner_AddController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = (int)$this->getParam('id');
        $wellLogId = (int)$this->getParam('well-log');
        
        // load well log
        $wellLogModel = new Well_Model_WellLog();
        $wellLog = $wellLogModel->loadById($wellLogId);
        $this->view->wellLog = $wellLog;
        
        // load location
        $locationModel = new Location_Model_Location();
        $location = $locationModel->loadById($id);
        $this->view->location = $location;
        
        $this->view->msg = $this->getParam('msg');
        
        $name = urldecode($this->getParam('name'));
        
        $formModel = new Owner_Form_Add();
        
        if(!empty($wellLog)){
        	$form = $formModel->owner($wellLog->name_first.' '.$wellLog->name_last,$wellLog->street,$wellLog->city,
        			$wellLog->state,$wellLog->zip);
        } elseif(!empty($location->street)) {
        	$form = $formModel->owner('',$location->street,$location->city,$location->state,$location->zip);
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
        		
        		$ownerModel = new Owner_Model_Owner();
        		$ownerId = $ownerModel->create($name, $street, $street2, $city, $state, $zip, $phone, $email, 1);
        		
        		// map location
        		$ownerLocationModel = new Owner_Model_OwnerLocation();
        		$ownerLocationModel->create($id, $ownerId, 1);
        		
        		$this->redirect('/location/view/index/id/' . $id.'/msg/location-add');
        	} else {
        		$form->highlightErrorElements();
        	}
        }
        
        
        
        
        $this->view->form = $form;
    }

    public function locationAction()
    {
    	$id = (int)$this->getParam('id');
    	if($id < 1) {
    		$this->redirect('/owner/add/error/msg/no-id');
    	}
    	
    	$ownerModel = new Owner_Model_Owner();
    	$owner = $ownerModel->loadById($id);
    	if(empty($owner)) {
    		$this->redirect('/owner/add/error/no-owner');
    	}
    	$this->view->owner = $owner;
    	
    	$formModel = new Owner_Form_Add();
    	$form = $formModel->location();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			print_r($this->getRequest()->getParams());
    			
    			$locationId = $this->getParam('locationId');
    			
    			$ownerLocationModel = new Owner_Model_OwnerLocation();
    			$ownerLocationModel->create($locationId, $id, 1);
    			
    			$this->redirect('/owner/view/index/id/' . $id.'/msg/location-add');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

}

