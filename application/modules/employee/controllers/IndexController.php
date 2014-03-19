<?php
/**
 * Client IndexController used to display all clients
 *
 * @author Jaimie Garner
 * @copyright 2013 Jaimie Garner
 *
 * @package Client
 * @category Controller
 * @version 1.0
 *
 * @todo Create pagination for rows of clients instead of pulling full data set
 */
class Employee_IndexController extends Zend_Controller_Action
{

	
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Action::init()
	 */
    public function init()
    {
       
    }

    /**
     * @todo
     */
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
    	
    	// load recent
    	$recentModel = new Location_Model_RecentLocation();
    	$recent = $recentModel->loadByEmployee($employeeId);
    	$this->view->recent = $recent;
    	
    	
    	// load marked
    	
    	$this->view->msg = $this->getParam('msg');
    }


}

