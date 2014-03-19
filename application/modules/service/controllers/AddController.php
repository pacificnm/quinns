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
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	if(empty($location)) {
    		$this->redirect('/service/add/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	// load owner
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owner = $ownerModel->loadOwnerByLocation($id);
    	
    	
    	
    	// load pumps
    	$pumpModel = new Pump_Model_Pump();
    	$pumps = $pumpModel->loadByLocation($id);
    	
    	$formModel = new Service_Form_Add();
    	$form = $formModel->service($owner,$pumps);
    	
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    		    
    		    $startTime = date("m/d/Y") . ' ' . $this->getParam('startHour').':'.$this->getParam('startMin').':00 ' . $this->getParam('startAmpm');
    		    $endTime   = date("m/d/Y") . ' ' . $this->getParam('endHour').':'.$this->getParam('endMin').':00 ' . $this->getParam('endAmpm');
    		    
    		    $startTimeStamp = strtotime($startTime);
    		    $endTimeStamp   = strtotime($endTime);
    		    
    		  
    		    
    			$employee = $this->getParam('employee');
    			$date = strtotime($this->getParam('date'));
    			$status = $this->getParam('status');
    			$description = $this->getParam('description');
    			$name = $this->getParam('owner');
    			$complaint = $this->getParam('complaint');
    			$directions = $this->getParam('directions');
    			$flowTest = $this->getParam('flow_test');
    			$pump =  $this->getParam('pump');
    			
    			
    			$auth = Zend_Auth::getInstance();
    			$identity = $auth->getIdentity();
    			$create = $identity['employeeId'];
    			
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
    			
    			$serviceModel = new Service_Model_Service();
    	
    			$id = $serviceModel->create($id,$ownerId,$employee,$date,$description,
    			        $complaint,$directions,$status,$flowTest,$pump,$create,0,$startTimeStamp,$endTimeStamp);
    			
    			$changeLogModule = new ChangeLog_Model_ChangeLog();
    			$changeLogModule->create('service',$id, 'Created	 Service');
    			
    			if($newOwner) {
    				$this->redirect('/owner/edit/index/id/' . $ownerId.'/from/service-add/service_id/'.$id.'/msg/owner-add-from-service');
    			} else {
    				$this->redirect('/service/view/index/id/' . $id.'/msg/service-add');
    			}
    			
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

