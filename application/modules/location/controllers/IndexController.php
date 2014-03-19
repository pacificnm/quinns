<?php

class Location_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {	
    	
    	
    	
    	if ($this->getRequest()->isPost()) {
    		
    		$page = 0;
    		
    		$keyword = $this->getParam('keywords');
   			$id = $this->getParam('locationId');
    		
    		if(!empty($id)) {
    			$this->redirect('/location/view/index/id/' . $id);
    		} else {
    			$address = $this->getParam('address');
    			
    			$LocationModelLocation = new Location_Model_Location();
    			 
    			$addresses =  $LocationModelLocation->loadByAddress($address);
    			 
    			$this->view->addresses = $addresses;
    			 
    			$this->view->address = $address;
    			}
    		}
    		
    	
    	} 

    	
    	


}

