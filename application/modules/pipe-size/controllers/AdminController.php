<?php
/**
 * Pipe-size Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pipe-size
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class PipeSize_AdminController extends Zend_Controller_Action
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
    	
    	$pipeSizeModel = new PipeSize_Model_PipeSize();
    	$pipeSize = $pipeSizeModel->loadAllPaginated($page);
    	$this->view->pipeSize = $pipeSize;
    	
    	$this->view->msg = $this->getParam('msg');
    }

    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new PipeSize_Form_Add();
    	$form = $formModel->pipeSize();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    	
    			$pipeSizeModel = new PipeSize_Model_PipeSize();
    			$id = $pipeSizeModel->create($value);
    	
    			$this->redirect('/pipe-size/admin/list/msg/add-ok');
    	
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }
    
    public function editAction()
    {
    	$id = $this->getParam('id');
    	
    	if($id < 1){
    		$this->redirect('/pipe-size/admin/error/msg/no-id');
    	}
    	
    	$pipeSizeModel = new PipeSize_Model_PipeSize();
    	$pipeSize = $pipeSizeModel->loadById($id);
    	
    	
    	if(empty($pipeSize)){
    		$this->redirect('/pipe-size/admin/error/msg/no-pipe-size');
    	}
    	$this->view->pipeSize = $pipeSize;
    	
    	$formModel = new PipeSize_Form_Edit();
    	$form = $formModel->pipeSize($pipeSize);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    	
    			$value = $this->getParam('value');
    	
    			$pipeSizeModel->edit($id, $value);
    			 
    			$this->redirect('/pipe-size/admin/list/msg/edit-ok');
    			 
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }
    
    public function deleteAction()
    {
    	$id = $this->getParam('id');
    	
    	if($id < 1){
    		$this->redirect('/pipe/admin/error/msg/no-id');
    	}
    	 
    	$pipeSizeModel = new PipeSize_Model_PipeSize();
    	$pipeSize = $pipeSizeModel->loadById($id);
    	 
    	if(empty($pipeSize)){
    		$this->redirect('/pipe-size/admin/error/msg/no-pipe');
    	}
    	$this->view->pipe = $pipe;
    	
    	$form = new Pipe_Form_Delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 
    			$pipeSizeModel->remove($id);
    			 
    			$this->redirect('/pipe-size/admin/list/msg/delete-ok');
    			 
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }
}

