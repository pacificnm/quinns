<?php

class PumpTest_ReportController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$this->_helper->layout->disableLayout();
    	
        $id = (int)$this->getParam('id');
        
        if($id < 1) {
        	$this->redirect('/pump-test/report/error/msg/missing-id');
        }
        
        // load pump test
        $pumpTestModel = new PumpTest_Model_PumpTest();
        try {
        	$pumpTest = $pumpTestModel->loadById($id);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/missing/pump-test');
        }
        
        // check if pump test is empty
        if(empty($pumpTest)) {
        	$this->redirect('/pump-test/report/error/msg/missing/pump-test/error/');
        }
        
        // load loaction
        $locationModel = new Location_Model_Location();
        try {
        	$location = $locationModel->loadById($pumpTest->location);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/no-location/error/');
        }
        
        // load owner
        $ownerModel = new Owner_Model_Owner();
        try {
        	$owner = $ownerModel->loadById($pumpTest->owner);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/no-owner/error/');
        }
        
        // load flow test
        $flowModel = new PumpTest_Model_PumpFlow();
        try {
        	$flow = $flowModel->loadByTest($pumpTest->id);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/no-flow/error/');
        }
        
        // load pump
        $pumpModel = new Pump_Model_Pump();
        try {
        	$pump = $pumpModel->loadById($pumpTest->pump);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/no-pump');
        }
        
        
        // load pdf
        $pdfModel = new PumpTest_Model_Pdf();
        try {
        	$pdf = $pdfModel->pumpTest($pumpTest, $flow, $location,$owner);
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/pdf-failed/error/');
        }

        
        // set headers
        try {
        	header("Content-Disposition: inline; filename=Well-Flow-Test-".$pumpTest->id.'.pdf');
        	header("Content-type: application/x-pdf");
        } catch (Exception $e) {
        	$this->redirect('/pump-test/report/error/msg/pdf-failed');
        }
        
        echo $pdf;
    }

    
	/**
	 * 
	 */
    public function errorAction()
    {
    	$msg   = (string)$this->getParam('msg');
    	$error = (string)urldecode($this->getParam('error'));
    	
    	$this->view->error = $error;
    	
    	switch($msg) {
    		case 'missing-id':
    			$this->view->msg = 'Missing required parameter id.';
    		break;
    		case 'pump-test':
    			$this->view->msg = 'Unable to load pump test.';
    		break;
    		case 'no-location':
    			$this->view->msg = 'Unable to load location.';
    		break;
    		case 'no-flow':
    			$this->view->msg = 'Unable to load flow data.';
    		break;
    		case 'pdf-failed':
    			$this->view->msg = 'Unable to create PDF.';
    		break;
    		case 'no-owner':
    			$this->view->msg = 'Unable to load owner.';
    		break;
    		default:
    			$this->view->msg = 'There was an unknown error.';
    	}
    	
    	// email error and record
    }
}

