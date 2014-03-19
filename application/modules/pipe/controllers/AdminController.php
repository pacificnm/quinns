<?php
/**
 * Pipe Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pipe
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Pipe_AdminController extends Zend_Controller_Action
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
    	 
    	$pipeModel = new Pipe_Model_Pipe();
    	$pipeTypes = $pipeModel->loadAll($page);
    	$this->view->pipeTypes = $pipeTypes;
    	 
    	$this->view->msg = $this->getParam('msg');
    }

    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new Pipe_Form_Add();
    	$form = $formModel->pipe();
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    			 
    			$pipeModel = new Pipe_Model_Pipe();
    			$id = $pipeModel->create($value);
    			 
    			$this->redirect('/pipe/admin/list/msg/add-ok');
    			 
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
    		$this->redirect('/pipe/admin/error/msg/no-id');
    	}
    	 
    	$pipeModel = new Pipe_Model_Pipe();
    	$pipe = $pipeModel->loadById($id);
    	 
    	if(empty($pipe)){
    		$this->redirect('/pipe/admin/error/msg/no-pipe');
    	}
    	$this->view->pipe = $pipe;
    	 
    	$formModel = new Pipe_Form_Edit();
    	$form = $formModel->pipe($pipe);
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 
    			$value = $this->getParam('value');
    			 
    			$pipeModel->edit($id,$value);
    			
    			$this->redirect('/pipe/admin/list/msg/edit-ok');
    	
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
    	
    	$pipeModel = new Pipe_Model_Pipe();
    	$pipe = $pipeModel->loadById($id);
    	
    	if(empty($pipe)){
    		$this->redirect('/pipe/admin/error/msg/no-pipe');
    	}
    	$this->view->pipe = $pipe;
    	 
    	$form = new Pipe_Form_Delete();
    	 
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$pipeModel->remove($id);
    			
    			$this->redirect('/pipe/admin/list/msg/delete-ok');
    	
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

}

