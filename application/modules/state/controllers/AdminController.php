<?php
/**
 * State Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package State
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class State_AdminController extends Zend_Controller_Action
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


    /**
     * 
     */
    public function listAction()
    {
    	$stateModel = new State_Model_State();
    	$states = $stateModel->loadAll();
    	$this->view->states = $states;
    	
    	$this->view->msg = $this->getParam('msg');
    }
    
    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new State_Form_Add();
    	$form = $formModel->state();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 $value = $this->getParam('value');
    			 
    			 $stateModel = new State_Model_State();
    			 
    			 $id = $stateModel->create($value);
    			 
    			 $this->redirect('/state/admin/list/msg/add-ok');
    			 
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
    		$this->redirect('/state/admin/error/msg/no-id');
    	}
    	 
    	$stateModel = new State_Model_State();
    	$state = $stateModel->loadById($id);
    	 
    	if(empty($state)){
    		$this->redirect('/state/admin/error/msg/no-city');
    	}
    	$this->view->state = $state;
    	
    	$formModel = new State_Form_Edit();
    	$form = $formModel->state($state);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    			
    			$stateModel->edit($id, $value);
    			
    			$this->redirect('/state/admin/list/msg/edit-ok');
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
    		$this->redirect('/state/admin/error/msg/no-id');
    	}
    	
    	$stateModel = new State_Model_State();
    	$state = $stateModel->loadById($id);
    	
    	if(empty($state)){
    		$this->redirect('/state/admin/error/msg/no-city');
    	}
    	$this->view->state = $state;
    	 
    	$formModel = new State_Form_Delete();
    	$form = $formModel->state();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 $stateModel->remove($id);
    			 $this->redirect('/state/admin/list/msg/delete-ok');
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
    			$this->view->msg = 'Missing state id.';
    			break;
    		case 'no-city':
    			$this->view->msg = 'Count not find state requested.';
    			break;
    		default:
    			$this->view->msg = 'Unknown error.';
    			break;
    	}
    }
}


