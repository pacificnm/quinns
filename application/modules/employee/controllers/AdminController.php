<?php

class Employee_AdminController extends Zend_Controller_Action
{
	
	
    public function init()
    {
       
    }

    /**
     * 
     */
    public function indexAction()
    {
    	$status = $this->getParam('status');
		
    	if(!isset($status)) {
    		$status = 1;
    	}
    	
    	
    	$formModel = new Employee_Form_Admin();
    	$form = $formModel->search($status);
    	
        // load employee model
        $employeeModel = new Employee_Model_Employee();
        $employees = $employeeModel->loadAllActive($status);
        
        
        
        
        $this->view->form = $form;
        $this->view->employees = $employees;
    }
    
    public function viewAction()
    {
    	$id = (int)$this->getParam('id');
    	if($id < 1){
    		$this->redirect('/employee/admin/error/msg/no-id');
    	}
    	
    	$employeeModel = new Employee_Model_Employee();
    	$employee = $employeeModel->loadById($id);
    	
    	if(empty($employee)) {
    		$this->redirect('/employee/admin/error/msg/no-employee');
    	}
    	$this->view->employee = $employee;
    }
    
    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new Employee_Form_Admin();
    	
    	$form = $formModel->add();
    	
    	
    	
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
    			$status = $this->getParam('status');
    			$password = $this->getParam('password');
    			$acl = $this->getParam('acl');
    			$type = 'employee';
    			
    			$employeeModel = new Employee_Model_Employee();
    			$employeeId = $employeeModel->create($firstName,$lastName,$email,$workPhone,$mobilePhone,$homePhone,
    					$jobTitle,$address,$im,$vehicle,$status,$password,$acl);
    			
    			if($status == '1'){
    				$status = 'active';
    			} else {
    				$status = 'suspended';
    			}
    			
    			$authModel = new Auth_Model_Auth();
    			$authModel->create($email, $password, $type, $employeeId, $status);
    			
    			$this->redirect('/employee/admin/view/id/'.$employeeId.'/msg/add-ok');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

    /**
     * 
     */
    public function editAction()
    {
    	$id = $this->getParam('id');
    	
    	if($id < 1){
    		$this->redirect('/employee/admin/error/msg/no-id');
    	}
    	 
    	$employeeModel = new Employee_Model_Employee();
    	$employee = $employeeModel->loadById($id);
    	 
    	if(empty($employee)){
    		$this->redirect('/employee/admin/error/msg/no-employee');
    	}
    	$this->view->employee = $employee;
    	
    	$formModel = new Employee_Form_Admin();
    	$form = $formModel->edit($employee);
    	
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
    			 $status = $this->getParam('status');
    			 $password = $this->getParam('password');
    			 $acl = $this->getParam('acl');
    			 
    			 $type = 'employee';
    			 
    			 $employeeModel->edit($id,$firstName,$lastName,$email,$workPhone,$mobilePhone,$homePhone,
    			 		$jobTitle,$address,$im,$vehicle,$status);
    			 
    			 if($status == '1'){
    			 	$status = 'active';
    			 } else {
    			 	$status = 'suspended';
    			 }
    			 
    			 $authModel = new Auth_Model_Auth();
    			 $authModel->edit($id, $type, $email, $password, $status, $acl);
    			 
    			 $this->redirect('/employee/admin/view/id/'.$id.'/msg/edit-ok');
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;	 
    }
    
    /**
     * 
     */
    public function deleteAction()
    {
    	$id = $this->getParam('id');
    	 
    	if($id < 1){
    		$this->redirect('/employee/admin/error/msg/no-id');
    	}
    	
    	$employeeModel = new Employee_Model_Employee();
    	$employee = $employeeModel->loadById($id);
    	
    	if(empty($employee)){
    		$this->redirect('/employee/admin/error/msg/no-employee');
    	}
    	$this->view->employee = $employee;
    	 
    	$formModel = new Employee_Form_Admin();
    	$form = $formModel->delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    	
    			$employeeModel->remove($id);
    			
    			// clean out employee stuff
    			
    			$this->redirect('/employee/admin/index/msg/employee-delete');
    		} else {
    			$form->highlightErrorElements();
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
    	 
    	switch($msg){
    		case 'no-id':
    			$this->view->msg = 'Missing Employee id.';
    			break;
    		case 'no-city':
    			$this->view->msg = 'Count not find Employee requested.';
    			break;
    		default:
    			$this->view->msg = 'Unknown error.';
    			break;
    	}
    }

}

