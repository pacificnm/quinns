<?php

class Owner_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	
    	if ($this->getRequest()->isPost()) {
    		$ownerModel = new Owner_Model_Owner();
    		$keyword = $this->getParam('owner');
    		
    		
    		$owner = $ownerModel->loadByName($keyword);
    		
    		
    		if(empty($owner)) {
    			$this->redirect('/owner/add/index/name/'.urlencode($keyword).'/msg/not-found');
    		} else {
    			$this->redirect('/owner/view/index/id/'.$owner->id);
    		}
    	}
    }


}

