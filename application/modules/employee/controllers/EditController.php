<?php

class Employee_EditController extends Zend_Controller_Action
{

	
    public function init()
    {
       
    }

    public function indexAction()
    {
    	// load employee
    	$authModel = Zend_Auth::getInstance();
    	$auth = $authModel->getIdentity();
    	
    	$employeeId = $auth['employeeId'];
    	$this->view->employeeId = $employeeId;
    	 
    	if($employeeId < 1) {
    		throw new Zend_Exception('Missing auth id');
    	}
    	 
    	// load Employee
    	$employeeModel = new Employee_Model_Employee();
    	$employee = $employeeModel->loadById($employeeId);
    	$this->view->employee = $employee;
    	
    	$formModel = new Employee_Form_Edit();
    	$form = $formModel->employee($employee);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$firstName = $this->getParam('first_name');
    			$lastName = $this->getParam('last_name');
    			$email = $this->getParam('email');
    			$workPhone = $this->getParam('work_phone');
    			$mobilePhone = $this->getParam('mobile_phone');
    			$homePhone = $this->getParam('home_phone');
    			$jobTitle = $this->getParam('job_title');
    			$address = $this->getParam('address');
    			$im = $this->getParam('im');
    			$vehicle = $this->getParam('vehicle');
    			$status = $employee->status;
    			$password = $this->getParam('password');
    			$acl = $employee->acl;
    	
    			$type = 'employee';
    	
    			$employeeModel->edit($employeeId,$firstName,$lastName,$email,$workPhone,$mobilePhone,$homePhone,
    					$jobTitle,$address,$im,$vehicle,1);
    	
    		
    			$authModel = new Auth_Model_Auth();
    			$authModel->edit($employeeId, $type, $email, $password, $status, $acl);
    	
    			$this->redirect('/employee/index/index/msg/edit-ok');
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }


}

