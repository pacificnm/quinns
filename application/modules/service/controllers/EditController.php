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


class Service_EditController extends Zend_Controller_Action
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
    	$id = $this->getParam('id');
    	
    	// load service
    	$serviceModel = new Service_Model_Service();
    	$service = $serviceModel->loadById($id);
    	$this->view->service = $service;
    	 
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($service->location);
    	$this->view->location = $location;
    	
    	// load owner
    	$ownerModel = new Owner_Model_Owner();
    	$owner = $ownerModel->loadById($service->owner);
    	 
    	// load pumps
    	$pumpModel = new Pump_Model_Pump();
    	$pumps = $pumpModel->loadByLocation($location->id);
 
    	
    	$formModel = new Service_Form_Edit();
    	$form = $formModel->service($service,$owner,$pumps);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$employee = $this->getParam('employee');
    			$date = strtotime($this->getParam('date'));
    			$status = $this->getParam('status');
    			$description = $this->getParam('description');
    			$name = $this->getParam('owner');
    			$complaint = $this->getParam('complaint');
    			$directions = $this->getParam('directions');
    			$flowTest = $this->getParam('flow_test');
    			$pump =  $this->getParam('pump');
    			
    			// check for owner name if none found create new owner
    			$ownerModel = new Owner_Model_Owner();
    			$ownerData = $ownerModel->loadByName($name);
    			 
    			if(empty($ownerData)){
    				$ownerId = $ownerModel->create($name, $street, $street2, $city, $state, $zip, $phone, $email, 1);
    				$newOwner = true;
    				$changeLogModule = new ChangeLog_Model_ChangeLog();
    				$changeLogModule->create('owner',$ownerId, 'Created Owner');
    			} else {
    				$ownerId = $ownerData->id;
    				$newOwner = false;
    			}
    			
    			
    			$serviceModel->edit($id,$ownerId,$employee,$date,$description,$complaint,$directions,$status,$flowTest,$pump);
    			
    			
    			
    			$this->redirect('/service/view/index/id/' . $id .'/msg/service-edit');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	
    	$this->view->form = $form;
    }


}

