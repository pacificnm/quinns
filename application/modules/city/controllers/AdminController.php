<?php
/**
 * City Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package City
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */
class City_AdminController extends Zend_Controller_Action
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
    	$cityModel = new City_Model_City();
    	$cities = $cityModel->loadAll();
    	$this->view->cities = $cities;
    	
    	$this->view->msg = $this->getParam('msg');
    }
    
    /**
     * 
     */
    public function addAction()
    {
    	$formModel = new City_Form_Add();
    	$form = $formModel->city();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$value = $this->getParam('value');
    			
    			$cityModel = new City_Model_City();
    			
    			$id = $cityModel->create($value);
    			
    			$this->redirect('/city/admin/list/msg/add-ok');
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
			$this->redirect('/city/admin/error/msg/no-id');
		}
    	
    	$cityModel = new City_Model_City();
    	$city = $cityModel->loadById($id);
    	
    	if(empty($city)){
    		$this->redirect('/city/admin/error/msg/no-city');
    	}
    	$this->view->city = $city;
    	
    	
    	$formModel = new City_Form_Edit();
    	$form = $formModel->city($city);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    				$value = $this->getParam('value');
    				
    				$cityModel->edit($id, $value);
    			
    			$this->redirect('/city/admin/list/msg/edit-ok');
    		}  else {
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
    		$this->redirect('/city/admin/error/msg/no-id');
    	}
    	 
    	$cityModel = new City_Model_City();
    	$city = $cityModel->loadById($id);
    	 
    	if(empty($city)){
    		$this->redirect('/city/admin/error/msg/no-city');
    	}
    	$this->view->city = $city;
    	 
    	$formModel = new City_Form_Delete();
    	$form = $formModel->city();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$cityModel->remove($id);
    			
    			$this->redirect('/city/admin/list/msg/delete-ok');
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
    			$this->view->msg = 'Missing city id.';
    		break;
    		case 'no-city':
    			$this->view->msg = 'Count not find city requested.';
    		break;
    		default:
    			$this->view->msg = 'Unknown error.';
    		break;
    	}
    }
}

