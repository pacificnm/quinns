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
    	
    	$owner = $ownerModel->loadById($ownerId);
    	if(empty($owner)) {
    		$this->redirect('/owner/edit/error/msg/no-owner');
    	}
    	$this->view->owner = $owner;
    	
    	$location = $ownerLocationModel->loadSingleLocationByOwner($ownerId);
    	if(empty($location)) {
    		$this->redirect('/owner/edit/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	
    	$status = $this->getParam('status');
    	$this->view->status = $status;
    	
    	$formModel = new Owner_Form_Edit();
    	
    	if($status == 'inactive') {
    		$form = $formModel->inactive();
    	} else {
    		$form = $formModel->active();
    	}
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			if($status == 'inactive') {
    				$ownerLocationModel->setInactive($ownerId, $locationId);
    			} else {
    				$ownerLocationModel->setActive($ownerId, $locationId);
    			}
    			$this->redirect('/owner/view/index/id/' . $ownerId.'/msg/edit-inactive');
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

