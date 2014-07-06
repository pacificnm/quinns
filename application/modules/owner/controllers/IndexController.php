<?php

class Owner_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$locationId = $this->getParam('location_id');
    	$this->view->locationId = $locationId;
    	
    }


}

