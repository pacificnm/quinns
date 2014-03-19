<?php
class Application_Plugin_Initialization extends  Zend_Controller_Plugin_Abstract
{
	protected $_auth;
	
	protected $_acl;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$front = Zend_Controller_Front::getInstance();
		
		$this->_auth = Zend_Auth::getInstance();

		// check if app is installed yet
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
		if(!$config->install->status) {
			$front->getRequest()->setModuleName('install');
			$front->getRequest()->setControllerName('index');
			$front->getRequest()->setActionName('index');
		}

		
		$requestModule = $front->getRequest()->getModuleName();
		$requestController = $front->getRequest()->getControllerName();
		$requestAction = $front->getRequest()->getActionName();
		
		// load module
		$moduleModel = new Application_Model_Module();
		$module = $moduleModel->getModuleByName($requestModule);
		
		// change log - dont record if its the audit page
		
		if($requestModule != 'report' and $requestController != 'audit') {
			$requestId = $front->getRequest()->getParam('id');
			$auth = $this->_auth->getIdentity();
			$employeeId = $auth['employeeId'];
			if(empty($employeeId)) $employeeId = 0;
			if(empty($requestId)) $requestId = 0;
			$changeLogModule = new ChangeLog_Model_ChangeLog();
			$uri = $front->getRequest()->getRequestUri();
			$changeLogModule->create($employeeId, $requestModule, $requestController, $requestId, $requestAction,  serialize($front->getRequest()), serialize($front->getRequest()->getParams()), $uri);
		}
		// check if module is not active
		if(empty($module)){
			throw new Zend_Exception('No Module for: ' . $requestModule);
		}
		
		// load controller
		$controllerModel = new Application_Model_Controller();
		$controller = $controllerModel->getControllerByName($module->module_id, $requestController);
		
		
		
		if(!empty($controller)) {
			$actionModel = new Application_Model_Action();
			$action = $actionModel->getActionByName($controller->controller_id, $requestAction);
			
			
			
			// if action is defined
			if(!empty($action)) {
				
				
				if($action->auth) {
					
					// validate if we need auth
					if(!$this->_auth->getIdentity()) {
						$front->getRequest()->setModuleName('auth');
						$front->getRequest()->setControllerName('signin');
        				$front->getRequest()->setActionName('index');
        				
					} else {	
						
						// check acl
						$role = $this->_auth->getIdentity();
						
						
						
						
						$this->_acl = new Application_Model_Acl();
						
					
						
						if(!$this->_acl->isAllowed($role['acl'], $action->acl)) {
							$front->getRequest()->setModuleName('default');
							$front->getRequest()->setControllerName('error');
							$front->getRequest()->setActionName('access-denied');
						}
						
					}

					// set meta tags and such
					
					$view = $front->getInstance()->getParam('bootstrap')->getResource('view');
					$view->headTitle($action['meta_title']);
				}
			} else {
				echo '<p style="color:red;">no action set for ' .$requestModule.'::'.$requestController.'::'.$requestAction.'</p>' ;
			}
		} else {
			echo '<p style="color:red;">no controller set for '.$requestModule.'::'.$requestController.'</p>';
		}
		
		
	
	}
}