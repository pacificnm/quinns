<?php
/**
 * Service Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Service
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Service_DeleteController extends Zend_Controller_Action
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
    	
    	$id = (int)$this->getParam('id');
    	if($id < 1) {
    		$this->redirect('/service/delete/index/error/msg/no-id');
    	}
    	
    	$serviceModel 	= new Service_Model_Service();
    	$locationModel 	= new Location_Model_Location();
    	
    	$service 	= $serviceModel->loadById($id);
    	$location 	= $locationModel->loadById($service->location);
    	
    	if(empty($service)) {
    		$this->redirect('/service/delete/index/error/msg/no-service');
    	}
    	
    	$form = new Service_Form_Delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$serviceModel->remove($id);
    			
    			$this->redirect('/location/view/index/id/' . $service->location.'/msg/delete-service');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	
    	$this->view->location 	= $location;
    	$this->view->service	= $service;
    	$this->view->form 		= $form;
    }


}

