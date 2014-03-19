<?php

class Admin_ModuleController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // load modules
        $moduleModel = new Application_Model_Module();
        $modules = $moduleModel->loadAll();
        $this->view->modules = $modules;
    }
    
    public function viewAction()
    {
    	$moduleId = $this->getParam('id');
    	
    	if($moduleId < 1) throw new Zend_Exception('No Id');
    	
    	$moduleModel = new Application_Model_Module();
    	$module = $moduleModel->loadById($moduleId);
    	$this->view->module = $module;
    	
    	// load controllers
    	$controllerModel = new Application_Model_Controller();
    	$controllers = $controllerModel->loadByModule($moduleId);
    	$this->view->controllers = $controllers;
    	
    }
    
    public function controllerAction()
    {
    	$controllerId = $this->getParam('id');
    	$controllerModel = new Application_Model_Controller();
    	$controller = $controllerModel->loadById($controllerId);
    	$this->view->controller = $controller;
    	
    	// load Module
    	$moduleModel = new Application_Model_Module();
    	$module = $moduleModel->loadById($controller->module_id);
    	$this->view->module = $module;
    	
    	// action
    	$actionModel = new Application_Model_Action();
    	$actions = $actionModel->loadByController($controllerId);
    	$this->view->actions = $actions;
    }

    
    public function addActionAction()
    {
    	$controllerId = $this->getParam('id');
    	$controllerModel = new Application_Model_Controller();
    	$controller = $controllerModel->loadById($controllerId);
    	$this->view->controller = $controller;
    	
    	// load module
    	$moduleModel = new Application_Model_Module();
    	$module = $moduleModel->loadById($controller->module_id);
    	$this->view->module = $module;
    	
    	// action model
    	$actionModel = new Application_Model_Action();
    	
    	$form = new Admin_Form_AddAction();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$name = $this->getParam('name');
    			$acl = $this->getParam('acl');
    			$auth = $this->getParam('auth');
    			
    			$actionId = $actionModel->create($controllerId, $name, $auth, $acl);
    			
    			$this->redirect('/admin/module/controller/id/'. $controllerId);
    			
    		}
    	}
    	$this->view->form = $form;
    }

    public function addControllerAction()
    {
    	$moduleId = $this->getParam('id');	
    	$moduleModel = new Application_Model_Module();
    	$module = $moduleModel->loadById($moduleId);
    	$this->view->module = $module;
    	
    	$form = new Admin_Form_AddController();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$controllerName = strtolower($this->getParam('name'));
    			$controllerModel = new Application_Model_Controller();
    			$controllerId = $controllerModel->create($moduleId, $controllerName);
    			
    			// create code
    			$controllerModel->writeController($module->name, $controllerName);
    			
    			if($this->getParam('include')) {
    				$actionModel = new Application_Model_Action();
    				$name = 'index';
    				$auth = '0';
    				$acl = '';
    				$actionId = $actionModel->create($controllerId, $name, $auth, $acl);
    				
    				$actionModel->writeView($module->name, $controllerName, 'index');
    				
    				$this->redirect('/admin/module/edit-action/id/'. $actionId);
    			}
    			
    		}
    	}
    	$this->view->form = $form;
    }
    
    public function editControllerAction()
    {
    	$controllerId = $this->getParam('id');
    	$controllerModel = new Application_Model_Controller();
    	$controller = $controllerModel->loadById($controllerId);
    	$this->view->controller = $controller;
    }
    
    public function editActionAction()
    {
    	// load Action
    	$actionId = $this->getParam('id');
    	$actionModel = new Application_Model_Action();
    	$action = $actionModel->loadById($actionId);
    	$this->view->action = $action;
    	
    	// load controller
    	$controllerModel = new Application_Model_Controller();
    	$controller = $controllerModel->loadById($action->controller_id);
    	$this->view->controller = $controller;
    	
    	// load module
    	$moduleModel = new Application_Model_Module();
    	$module = $moduleModel->loadById($controller->module_id);
    	$this->view->module = $module;
    	
    	$formModel = new Admin_Form_EditAction();
    	$form = $formModel->action($action);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$name = $this->getParam('name');
    			$auth = $this->getParam('auth');
    			$acl = $this->getParam('acl');
    			$metaTitle = $this->getParam('meta_title');
    			
    			$actionModel->edit($actionId,$name,$auth,$acl,$metaTitle);
    			
    			$this->redirect('/admin/module/controller/id/'.$controller->controller_id);
    		}
    	}
    	$this->view->form = $form;
    }
    
    public function editModuleAction()
    {
    	
    }
    
    public function disableModuleAction()
    {
    	
    }
    
    /**
     * 
     */
    public function addModuleAction()
    {
    	$form = new Admin_Form_AddModule();
    	
    	$moduleModel = new Application_Model_Module();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$name = $this->getParam('name');
    			$include = $this->getParam('include');
    			
    			// create module
    			$moduleId = $moduleModel->create($name);
    			
    			// Build folders
    			$modulePath = $moduleModel->createModuleDir($name);
    			
    			// write bootstrap file
    			$moduleModel->writeBootstrap($name);
    			
    			if($include) {
    				// build controllers
    				$controllerModel = new Application_Model_Controller();
    				$actionModel = new Application_Model_Action();
    				
    				// admin
    				$controllerModel->writeController($name, 'admin');
    				$actionModel->writeView($name, 'admin', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'admin');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    				
    				// add
    				$controllerModel->writeController($name, 'add');
    				$actionModel->writeView($name, 'add', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'add');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    				
    				// edit
    				$controllerModel->writeController($name, 'edit');
    				$actionModel->writeView($name, 'edit', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'edit');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    				
    				// delete
    				$controllerModel->writeController($name, 'delete');
    				$actionModel->writeView($name, 'delete', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'delete');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    				
    				// index
    				$controllerModel->writeController($name, 'index');
    				$actionModel->writeView($name, 'index', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'index');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    				
    				// view
    				$controllerModel->writeController($name, 'view');
    				$actionModel->writeView($name, 'view', 'index');
    				$controllerId = $controllerModel->create($moduleId, 'view');
    				$actionId = $actionModel->create($controllerId, 'index', 0, '');
    			}
    		}
    	}
    	
    	$this->view->form = $form;
    }
}

