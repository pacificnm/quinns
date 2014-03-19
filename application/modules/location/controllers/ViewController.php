<?php
/**
 * Location Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Location
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Location_ViewController extends Zend_Controller_Action
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
    	$authModel = Zend_Auth::getInstance();
    	$auth = $authModel->getIdentity();
    	
    	$employeeId = $auth['employeeId'];
    	
    	if($employeeId < 1){
    		throw new Zend_Exception('Missing Employee ID can not set viewed location.');
    	}
    	
    	$id = (int)$this->getParam('id');
    	if($id < 1){
    		$this->redirect('/location/view/error/msg/no-id');
    	}
    	
    	
    	// Load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	if($location->id < 1) {
    		$this->redirect('/location/view/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	// load pumps
    	$pumpModel = new Pump_Model_Pump();
    	$pumps = $pumps = $pumpModel->loadByLocation($id);
    	$this->view->pumps = $pumps;
    	
    	// load owners
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($id);
    	$this->view->owners = $owners;
    	
    	// load pumptest
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadByLocationLast($id);
    	$this->view->pumpTest = $pumpTest;
    	$this->view->pumpTestCount = count($pumpTest);
    	
    	// load services
    	$page = $this->getParam('page');
    	$serviceModel = new Service_Model_Service();
    	$services = $serviceModel->loadByLocation($id,$page);
    	$this->view->services = $services;
    	
    	// load next service date
    	$scheduleModule = new Schedule_Model_Schedule();
    	$schedule = $scheduleModule->loadByLocation($id);
    	$this->view->schedule = $schedule;
    	
    	// save recent
    	$recentModel = new Location_Model_RecentLocation();
    	$recent = $recentModel->loadByEmployeeLocation($employeeId, $id);
    	if(empty($recent)) {
    		$recentModel->create($employeeId, $id);
    	}
    	
    	if(!empty($location->lat) and !empty($location->lng)) {
    		$nearbyWells = $locationModel->loadNearBy($location->lat, $location->lng);
    		$this->view->nearbyWells = $nearbyWells;
    	}
    	
    	$msg = $this->getParam('msg');
    	$this->view->msg = $msg;

    }

	public function noteAction()
	{
		$id = $this->getParam('id');
		 
		// Load location
		$locationModel = new Location_Model_Location();
		$location = $locationModel->loadById($id);
		$this->view->location = $location;
		
		// load notes
		$noteModel = new Location_Model_LocationNote();
		$note = $noteModel->loadByLocation($id);
		$this->view->note = $note;
		
		$msg = $this->getParam('msg');
		$this->view->msg = $msg;
	}
	
	public function mapAction()
	{
		$id = $this->getParam('id');
			
		// Load location
		$locationModel = new Location_Model_Location();
		$location = $locationModel->loadById($id);
		$this->view->location = $location;
		
		$geoModel = new Geo_Model_Geo();
		$geo = $geoModel->loadByLocation($location->id);
		$this->view->geo = $geo;
	
		$this->view->msg = $this->getParam('msg');
		
	}
	
	public function reportAction()
	{
		$id = (int)$this->getParam('id');
		if($id < 1) {
			$this->redirect('/location/view/error/msg/no-id');
		}
		
		$locationModel = new Location_Model_Location();
		$location = $locationModel->loadById($id);
		if(empty($location)){
			$this->redirect('/location/view/error/msg/no-location');
		}
		
		// owner 
		$ownerModel = new Owner_Model_OwnerLocation();
		$owner = $ownerModel->loadOwnerByLocation($id);
		
		// load next service date
		$scheduleModule = new Schedule_Model_Schedule();
		$schedule = $scheduleModule->loadByLocation($id);
		
		// load notes
		$noteModel = new Location_Model_LocationNote();
		$note = $noteModel->loadByLocation($id);
		
		// load pumps
		$pumpModel = new Pump_Model_Pump();
		$pumps = $pumps = $pumpModel->loadByLocation($id);
		
		// load flow tests
		$pumpTestModel = new PumpTest_Model_PumpTest();
		$pumpTests = $pumpTestModel->loadByLocation($id);
		
		// load service records
		$serviceModel = new Service_Model_Service();
		$services = $serviceModel->loadAllServiceByLocation($id);
		
		$pdfModel = new Location_Model_Pdf();
		
		$pdf = $pdfModel->location($location,$owner,$schedule,$pumps,$note,$pumpTests,$services);
		
		$this->_helper->layout->disableLayout();
		
		header("Content-Disposition: inline; filename=result.pdf");
		header("Content-type: application/x-pdf");
		
		echo $pdf;
	}
	
	public function oldAction()
	{
	    $id = $this->getParam('id');
	    if($id < 1 ) {
	        throw new Zend_Exception('Missing id');
	    }
	    $WellModelWell = new Well_Model_Well();
	    
	    $wellData = $WellModelWell->loadByid($id);
	    
	    $rowArray = $wellData->toArray();
	    
	    
	    $this->view->welldata = $rowArray;
	}
	
	public function errorAction()
	{
		
	}
}

