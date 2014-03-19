<?php
/**
 * Pump-type Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pump-type
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class PumpType_AdminController extends Zend_Controller_Action
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
    	$page = (int)$this->getParam('page',1);
    	 
    	$pumpTypeModel = new PumpType_Model_PumpType();
    	$pumpTypes = $pumpTypeModel->loadAll($page);
    	$this->view->pumpTypes = $pumpTypes;
    	 
    	$this->view->msg = $this->getParam('msg');
    }
    
    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new PumpType_Form_Add();
    	$form = $formModel->pumpType();
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    			 
    			$pumpTypeModel = new PumpType_Model_PumpType();
    			 
    			$id = $pumpTypeModel->create($value);
    			 
    			$this->redirect('/pump-type/admin/list/msg/add-ok');
    			 
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
    		$this->redirect('/pump-type/admin/error/msg/no-id');
    	}
    	 
    	$pumpTypeModel = new PumpType_Model_PumpType();
    	$pumpType = $pumpTypeModel->loadById($id);
    	 
    	if(empty($pumpType)){
    		$this->redirect('/pump-type/admin/error/msg/no-city');
    	}
    	$this->view->pumpType = $pumpType;
    	 
    	$formModel = new PumpType_Form_Edit();
    	$form = $formModel->pumpType($pumpType);
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 
    			$value = $this->getParam('value');
    			
    			$pumpTypeModel->edit($id,$value);
    			 
    			$this->redirect('/pump-type/admin/list/msg/edit-ok');
    	
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
    		$this->redirect('/pump-type/admin/error/msg/no-id');
    	}
    	
    	$pumpTypeModel = new PumpType_Model_PumpType();
    	$pumpType = $pumpTypeModel->loadById($id);
    	
    	if(empty($pumpType)){
    		$this->redirect('/pump-type/admin/error/msg/no-city');
    	}
    	$this->view->pumpType = $pumpType;
    	 
    	$form = new PumpType_Form_Delete();
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$pumpTypeModel->remove($id);
    			 
    			$this->redirect('/pump-type/admin/list/msg/delete-ok');
    	
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }


}

