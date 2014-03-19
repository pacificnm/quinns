<?php

class Employee_AddController extends Zend_Controller_Action
{
	/**
	 *
	 * @var unknown
	 */
	protected $_auth;
	
	/**
	 *
	 * @var Zend_Translate
	 */
	protected $_translate;
	
    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
        
        // if no auth redirect to login
        if(!$this->_auth->getIdentity()) {
        	$this->redirect('/auth/signin');
        }
        
        // Set Translate
        $this->_translate =  Zend_Registry::get('Zend_Translate_Employee');
    }

    public function indexAction()
    {
        $form = new Employee_Form_Add();
        
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($this->getRequest()->getPost())) {
        		
        		$firstName = $this->getParam('first_name');
        		$lastName = $this->getParam('last_name');
        		$email = $this->getParam('email');
        		$password = $this->getParam('password');

        		$employeeModel = new Employee_Model_Employee();
        		$employeeId = $employeeModel->create($firstName,$lastName,$email );
        		
        		
        		$type = 'employee';
        		$status = 'active';
        		
        		$authModel = new Auth_Model_Auth();
        		$authModel->create($email, $password, $type, $employeeId, $status);
        		
        		$this->redirect('/employee/admin/index');
        	}
        }
        
        $this->view->form = $form;
    }


}

