<?php

class Report_SecurityController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$formModel 		= new Report_Form_Security();
    	$securityModel 	= new Security_Model_Security();
    	
    	$form = $formModel->search();
    	
    	$page = $this->getParam('page');
    	
    	$status = $this->getParam('status');
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    	
        		$startDate 	= strtotime($this->getParam('startDate'));
    			$endDate 	= strtotime($this->getParam('endDate'));
    			
    			if(empty($startDate) or empty($endDate)) {
    				$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    				$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    			}
    			
    		} else {

    			$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    			$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    		}
    	} else {
    		$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    		$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    	}
    	
    	$logs = $securityModel->loadAll($page, $startDate, $endDate, $status);
    	
    	$this->view->logs = $logs;
    	$this->view->form = $form;
    }


}

