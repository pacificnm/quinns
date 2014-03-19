<?php

class Report_AuditController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	$formModel = new Report_Form_Audit();
    	$form = $formModel->main();
       	
		$page = $this->getParam('page');
    	
    	$changeLogModel = new ChangeLog_Model_ChangeLog();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$employee = $this->getParam('employee');
    			$startDate = strtotime($this->getParam('startDate'));
    			$endDate = strtotime($this->getParam('endDate'));
    			
    			if(empty($startDate)) $startDate = mktime(0, 0, 0, date("m"), 1, date("Y"));
    			if(empty($endDate)) { 
    				$endDate = mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    			} else {
    				$endDate = $endDate + 86400;
    			}
    			
    			$module = $this->getParam('sModule');
    			
    			$logs = $changeLogModel->loadByEmployee($employee, $startDate, $endDate, $module, $page);
    			
    		} else {
    			$form->highlightErrorElements();
    			
    			$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    			$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    			$employee 	= 0;
    			
    			$logs = $changeLogModel->loadByEmployee($employee, $startDate, $endDate, $page);
    			
    		}
    	} else {
    		$logs = $changeLogModel->loadAll($page);
    	}
    	
    	$this->view->logs = $logs;
    	
    	$this->view->form = $form;
    }

    
    public function viewAction()
    {
    	$id = $this->getParam('id');
    	
    	$changeLogModule = new ChangeLog_Model_ChangeLog();
    	$changeLog = $changeLogModule->loadById($id);
    	$this->view->changeLog = $changeLog;
    }

    /**
     * 
     */
    public function pageAction()
    {
    	$uri 	= urldecode($this->getParam('uri'));
    	$uri 	= str_replace(":", "/", $uri);
    	
    	$page 	= $this->getParam('page');
    	
    	$changeLogModel = new ChangeLog_Model_ChangeLog();
    	
    	$formModel = new Report_Form_Audit();
    	$form = $formModel->page();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$employee 	= $this->getParam('employee');
    			$startDate 	= strtotime($this->getParam('startDate'));
    			$endDate 	= strtotime($this->getParam('endDate')) + 86400;
    			
    			$logs = $changeLogModel->loadByUri($uri, $startDate, $endDate, $employee, $page);
    			
    		} else {
    			$form->highlightErrorElements();
    			$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    			$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    			$employee 	= 0;
    			
    			$logs = $changeLogModel->loadByUri($uri, $startDate, $endDate, $employee, $page);
    		}
    	} else {
    		
    		$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    		$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    		$employee 	= 0;
    		
    		$logs = $changeLogModel->loadByUri($uri, $startDate, $endDate, $employee, $page);
    		
    	}
    	
    	$this->view->form = $form;
    	
    	$this->view->logs = $logs;
    }
   
}

