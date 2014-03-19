<?php
/**
 * Employee Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Employee
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Employee_DeleteController extends Zend_Controller_Action
{

    /**
     * Init
     */
    public function init()
    {
    }

    /**
     * indexAction
     */
    public function indexAction()
    {
    }

    public function recentAction()
    {
    	$id = (int)$this->getParam('id');
    	
    	
    	$recentModel = new Location_Model_RecentLocation();
    	$recent = $recentModel->loadById($id);
    	
    	$authModel = Zend_Auth::getInstance();
    	$auth = $authModel->getIdentity();
    	 
    	$employeeId = $auth['employeeId'];
    	 
    	if($employeeId < 1){
    		throw new Zend_Exception('Missing Employee ID can not set viewed location.');
    	}
    	
    	if($recent->employee != $employeeId) {
    		$this->redirect('/error/access-denied');
    	} else {
    		$recentModel->remove($id);
    		$this->redirect('/employee/index/index/msg/recent-removed');
    	}
    }

    
    public function allRecentAction()
    {
    	$authModel = Zend_Auth::getInstance();
    	$auth = $authModel->getIdentity();
    	
    	$employeeId = $auth['employeeId'];
    	
    	if($employeeId < 1){
    		throw new Zend_Exception('Missing Employee ID can not set viewed location.');
    	}
    	
    	$recentModel = new Location_Model_RecentLocation();
    	$recentModel->removeAllByEmployee($employeeId);
    	$this->redirect('/employee/index/index/msg/recent-removed');
    }
}

