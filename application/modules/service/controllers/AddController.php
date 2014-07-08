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


class Service_AddController extends Zend_Controller_Action
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
    		$this->redirect('/service/add/error/msg/no-id');
    	}
    	
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($id);
    	
    	if(count($owners) < 1 ) {
    	
    	    $this->redirect('/location/view/index/id/' . $id.'/msg/no-contact-service');
    	}
    	
    	
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	if(empty($location)) {
    		$this->redirect('/service/add/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	// load owner
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($id);
    	
    	
    	
    	
    	// load pumps
    	$pumpModel = new Pump_Model_Pump();
    	$pumps = $pumpModel->loadByLocation($id);
    	
    	$formModel = new Service_Form_Add();
    	$form = $formModel->service($owners,$pumps);
    	
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    		    
    			$date = strtotime($this->getParam('date'));
    			
    			// start time
    			$startHour = $this->getParam('startHour');
    			if($startHour == 0 && $this->getParam('startMin') == 0) {
    			    $startTime = 0;
    			} else {
    			    if($this->getParam('startAmpm') == 'PM' && $startHour < 12) {
    			        $startHour = $startHour + 12;
    			        
    			    }
    			    $startTime = mktime($startHour, $this->getParam('startMin'), 0, date("m", $date), date("d", $date), date("Y",$date));
    			}
    			 
    			// end time
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
    			
    		
    			
    			$auth = Zend_Auth::getInstance();
    			$identity = $auth->getIdentity();
    			$create = $identity['employeeId'];
  
    			$serviceModel = new Service_Model_Service();
    	
    			$id = $serviceModel->create($id,$ownerId,$employee,$date,$description,
    			        $complaint,$directions,$status,$flowTest,$pump,$create,0,$startTime,$endTime);
    			
    			$changeLogModule = new ChangeLog_Model_ChangeLog();
    			$changeLogModule->create('service',$id, 'Created	 Service');
    			
    			$this->redirect('/service/view/index/id/' . $id.'/msg/service-add');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }


    public function errorAction()
    {
    	
    }
}

