<?php

class Owner_EditController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$id = (int)$this->getParam('id');
        
        if($id < 1) {
        	$this->redirect('/owner/edit/error/msg/no-id');
        }
        
        $ownerModel = new Owner_Model_Owner();
        $owner = $ownerModel->loadById($id);
        $this->view->owner = $owner;
        
        if(empty($owner)) {
        	$this->redirect('/owner/edit/error/msg/no-owner');
        }
        
        // if request came from service add.
        $serviceId = $this->getParam('service_id');
        $this->view->msg = $this->getParam('msg');
        
        
        $formModel = new Owner_Form_Edit();
        $form = $formModel->owner($owner);
        
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
        		
        		$ownerModel->edit($id, $name, $street, $street2, $city, $state, $zip, $phone, $email);
        		
        		if($serviceId > 0) {
        			$this->redirect('/service/view/index/id/' . $serviceId.'/msg/service-add');
        		} else {
        			$this->redirect('/owner/view/index/id/' .$id.'/msg/owner-edit');
        		}
        		
        	} else {
        		$form->highlightErrorElements();
        	}
        }
        $this->view->form = $form;
    }

    /**
     * 
     */
    public function locationAction()
    {
    	$locationId = (int)$this->getParam('location');
    	$ownerId = (int)$this->getParam('owner');
    	
    	if($locationId < 1) {
    		$this->redirect('/owner/edit/error/msg/no-location');
    	}
    	
    	if($ownerId < 1) {
    		$this->redirect('/owner/edit/error/msg/no-owner');
    	}
    	
    	$ownerModel = new Owner_Model_Owner();
    	$ownerLocationModel = new Owner_Model_OwnerLocation();
    	$locationModel = new Location_Model_Location();
    	
    	$owner = $ownerModel->loadById($ownerId);
    	if(empty($owner)) {
    		$this->redirect('/owner/edit/error/msg/no-owner');
    	}
    	$this->view->owner = $owner;
    	
    	$data = $ownerLocationModel->loadByOwnerLocation($locationId, $ownerId);
    	if(empty($data)) {
    		$this->redirect('/owner/edit/error/msg/no-location');
    	}
    	
    	$location = $locationModel->loadById($locationId);
    	$this->view->location = $location;

    	$formModel = new Owner_Form_Edit();
    	$form = $formModel->location($data);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$status = $this->getParam('status');
    			$ownerType = $this->getParam('owner_type');
    			
    			// if we delete
    			if($status == 2) {
    				$ownerLocationModel->delete($data->id);
    				$this->redirect('/owner/view/index/id/' . $ownerId);
    			} else {
    				$ownerLocationModel->update($data->id, $ownerType, $status);
    				$this->redirect('/owner/view/index/id/' . $ownerId);
    			}
    		}
    	}
    	
    	$this->view->form = $form;
    }
    
    
    
	/**
	 * 
	 */
    public function errorAction()
    {
    	$msg = $this->getParam('msg');
    	
    	switch ($msg) {
    		
    	}
    }
}

