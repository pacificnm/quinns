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
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($location->id);
    	 
    	// load pumps
    	$pumpModel = new Pump_Model_Pump();
    	$pumps = $pumpModel->loadByLocation($location->id);
 
    	
    	$formModel = new Service_Form_Edit();
    	$form = $formModel->service($service, $owners,$pumps);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$date = strtotime($this->getParam('date'));
    			
    			// start time
    			$startHour = $this->getParam('startHour');
    			if($startHour == 0 && $this->getParam('startMin') == 0) {
    			    $startHour = 0;
    			} else {
    			    if($this->getParam('startAmpm') == 'PM' && $startHour < 12) {
    			        $startHour = $startHour + 12;
    			    }
    			    $startTime = mktime($startHour, $this->getParam('startMin'), 0, date("m", $date), date("d", $date), date("Y",$date));     			    
    			} 
    			
    			// end hour
    			$endHour = $this->getParam('endHour');
    			if($endHour == 0 && $this->getParam('endMin') == 0) {
    			    $endTime = 0;
    			} else {
    			    if($this->getParam('endAmpm') == 'PM' && $endHour < 12) {
    			        $endHour = $endHour + 12;
    			    }
    			    $endTime = mktime($endHour, $this->getParam('endMin'), 0, date("m", $date), date("d", $date), date("Y",$date));
    			}
    			
    			
    			$employee = $this->getParam('employee');
    			
    			$status = $this->getParam('status');
    			$description = $this->getParam('description');
    			$name = $this->getParam('owner');
    			$complaint = $this->getParam('complaint');
    			$directions = $this->getParam('directions');
    			$flowTest = $this->getParam('flow_test');
    			$pump =  $this->getParam('pump');
    			$ownerId = $this->getParam('owner_id');
    			
    			// check for owner name if none found create new owner
    			$ownerModel = new Owner_Model_Owner();
    			$ownerData = $ownerModel->loadByName($name);
    			 
    			
    			
    			$serviceModel->edit($id,$ownerId,$employee,$date,$description,$complaint,$directions,$status,$flowTest,$pump, $startTime, $endTime);
    			
    			
    			
    			$this->redirect('/service/view/index/id/' . $id .'/msg/service-edit');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	
    	$this->view->form = $form;
    }


}

