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


class Service_ViewController extends Zend_Controller_Action
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
    	
    	$this->view->msg = $this->getParam('msg');
    	
    }

    
    public function oldAction()
    {
        $id = $this->getParam('id');
        if($id < 1 ) {
            throw new Zend_Exception('Missing id');
        }
        $ServiceModelService = new Service_Model_Service();
        $WellModelWell = new Well_Model_Well(); 
        
        $wellData = $ServiceModelService->loadOldServiceById($id);
        $rowArray = $wellData->toArray();
        $this->view->welldata = $rowArray;
        
        $pumptableDate = $WellModelWell->loadByid($wellData->CustID);
        $rowArray = $pumptableDate->toArray();
        $this->view->pumpdatatable = $pumptableDate;
    }
    
    public function reportAction()
    {
    	$id = $this->getParam('id');

    	// load service
    	$serviceModel = new Service_Model_Service();
    	$service = $serviceModel->loadById($id);
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($service->location);
    	
    	// load notes
    	$noteModel = new Location_Model_LocationNote();
    	$note = $noteModel->loadByLocation($service->location);
    	
    	// load owner
    	$ownerModel = new Owner_Model_Owner();
    	$owner = $ownerModel->loadById($service->owner);
    	
    	// load pump
    	$pumpModel = new Pump_Model_Pump();
    	$pump = $pumpModel->loadById($service->pump);
    	
    	// load driections
    	$geoModel = new Geo_Model_Geo();
    	$geo = $geoModel->loadByLocation($service->location);
    	
    	// flow test
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTests = $pumpTestModel->loadByLocation($service->location);
    	
    	// load old service orders
    	$oldServices = $serviceModel->loadPastWorkOrders($service->location);
    	
    	$pdfModel = new Service_Model_Pdf();
    	
    	$pdf = $pdfModel->service($service,$location,$owner,$note,$pump,$geo,$pumpTests, $oldServices);
    	
    	$this->_helper->layout->disableLayout();
    	
    	header("Content-Disposition: inline; filename=Service-Report-".$service->id.'.pdf');
    	header("Content-type: application/x-pdf");
    	
    	echo $pdf;
    }

}

