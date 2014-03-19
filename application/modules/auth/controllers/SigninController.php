<?php
/**
 * 
 * @author Jaimie
 *
 */
class Auth_SigninController extends Zend_Controller_Action
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Action::init()
	 */
    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * 
     */
    public function indexAction()
    {
    	$configModel = new Application_Model_Config();
    	
    	$allowSignUp = $configModel->loadByProperty('allowSignUp');
    	$allowLostPassword = $configModel->loadByProperty('allowLostPassword');
    	$this->view->allowSignUp = $allowSignUp;
    	$this->view->allowLostPassword = $allowLostPassword;
  
    	
    	$form = new Auth_Form_Signin();
    	
    	// if we have a form post
        if ($this->getRequest()->isPost()) {
        	
			// if form is valid
            if ($form->isValid($this->getRequest()->getPost())) {

            	$authModel = new Auth_Model_Auth();
            	
                // do something here to log in
            	if ($authModel->process($form->getValues())) {
            	
            	
            		
            		$auth = Zend_Auth::getInstance();
            		
            		// get user Ip
            		$ipModel = new Application_Model_IpAddress();
            		$lastIp = $ipModel->getUserIp();
            		
            		// set last login time and from where
            		$authModel->setLastSigngin($auth->getIdentity()->auth_id, time(), $lastIp);
            		
            		
            		// check status
            		if($auth->getIdentity()->status != 'active') {
            			$auth->clearIdentity();
            			$this->redirect('/auth/signin/fail');
            		}

            		// load user type
            		switch ($auth->getIdentity()->type) {
            			
            			// if we are an employee set up the session
            			case 'employee':
            				$employeeModel = new Employee_Model_Employee();
            				$employee = $employeeModel->loadById($auth->getIdentity()->id);
            				
            				// check that email for employee table matches login. if not redirect to update email
            				if($auth->getIdentity()->email != $employee->email) {
            					$this->_redirect('/employee/update/email/');
            				}
            				
            				
            				// load storage
            				$storage = $auth->getStorage();
            				
            				// set new session data
            				$contents = array(
            					'authId' => $auth->getIdentity()->auth_id,
            					'employeeId' => $auth->getIdentity()->id,
            					'firstName' => $employee->first_name,
            					'lastName' => $employee->last_name,
            					'email' => $employee->email,
            					'type'	=> 'employee',
            					'acl'	=> $auth->getIdentity()->acl
            						);
            				$storage->write($contents);

            				$securityModel = new Security_Model_Security();
            				$securityModel->create(time(), 'success', serialize($this->getRequest()->getParams()));
            				
            				$this->redirect('/employee/index');
            			break;
            			
            			
            			
            			// if we are a client
            			case 'client':
            				$clientModel = new Client_Model_Client();
            				$client = $clientModel->getClient($auth->getIdentity()->id);
            			break;
            			default:
            				$auth->clearIdentity();
            				$this->_redirect('/auth/signin');
            			break;
            		}
            	
            	}
            } else {
            	$securityModel = new Security_Model_Security();
            	$securityModel->create(time(), 'fail', serialize($this->getRequest()->getParams()));
            	$form->highlightErrorElements();
            }
            $securityModel = new Security_Model_Security();
            $securityModel->create(time(), 'fail', serialize($this->getRequest()->getParams()));
            $form->highlightErrorElements();	
        }

        $this->view->form = $form;
    }

    public function failAction()
    {
    	
    }
}

