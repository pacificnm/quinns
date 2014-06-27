<?php

class Owner_ViewController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = (int)$this->getParam('id');
        
        if($id < 1) {
        	$this->redirect('/owner/view/error/msg/no-id');
        }
        
        $ownerModel = new Owner_Model_Owner();
        $owner = $ownerModel->loadById($id);
        
        
        
        $this->view->owner = $owner;
        
        if(empty($owner)) {
        	$this->redirect('/owner/view/error/no-owner');
        }
        
        $locationModel = new Owner_Model_OwnerLocation();
        $location = $locationModel->loadLocationByOwner($id);
        $this->view->location = $location;
        
        $this->view->msg = $this->getParam('msg');
    }


}

