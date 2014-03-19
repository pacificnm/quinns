<?php
/**
 * Pump-model  Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pump-model 
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class PumpModel_AdminController extends Zend_Controller_Action
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
    	
    	$pumpModelModel = new PumpModel_Model_PumpModel();
    	$pumpModels = $pumpModelModel->loadAll($page);
    	$this->view->pumpModels = $pumpModels;
    	
    	$this->view->msg = $this->getParam('msg');
    }
    
    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new PumpModel_Form_Add();
    	$form = $formModel->pumpModel();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    			
    			$pumpModelModel = new PumpModel_Model_PumpModel();
    			
    			$id = $pumpModelModel->create($value);
    			
    			$this->redirect('/pump-model/admin/list/msg/add-ok');
    			
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
    		$this->redirect('/pump-model/admin/error/msg/no-id');
    	}
    	
    	$pumpModelModel = new PumpModel_Model_PumpModel();
    	$pumpModel = $pumpModelModel->loadById($id);
    	
    	if(empty($pumpModel)){
    		$this->redirect('/pump-model/admin/error/msg/no-pump-type');
    	}
    	$this->view->pumpModel = $pumpModel;
    	
    	$formModel = new PumpModel_Form_Edit();
    	$form = $formModel->pumpModel($pumpModel);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$value = $this->getParam('value');
    			$pumpModelModel->edit($id, $value);
    			
    			$this->redirect('/pump-model/admin/list/msg/edit-ok');
    			 
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
    		$this->redirect('/pump-model/admin/error/msg/no-id');
    	}
    	 
    	$pumpModelModel = new PumpModel_Model_PumpModel();
    	$pumpModel = $pumpModelModel->loadById($id);
    	 
    	if(empty($pumpModel)){
    		$this->redirect('/pump-model/admin/error/msg/no-city');
    	}
    	$this->view->pumpModel = $pumpModel;
    	
    	$form = new PumpModel_Form_Delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$pumpModelModel->remove($id);
    			
    			$this->redirect('/pump-model/admin/list/msg/delete-ok');
    			 
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

}

