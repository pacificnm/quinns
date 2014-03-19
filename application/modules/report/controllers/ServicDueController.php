<?php

class Report_ServicDueController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	$startDate = $this->getParam('startDate');
    	$endDate = $this->getParam('endDate');
    	
    	if(empty($startDate) or empty($endDate)) {
    		$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    		$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    	}
    	
    	$serviceModel = new Schedule_Model_Schedule();
    	
    	$results = $serviceModel->loadByDateNoPage($startDate, $endDate);
    	
    	$pdfModel = new Report_Model_Pdf();
    	
    	$pdf = $pdfModel->serviceDue($results, $startDate, $endDate);
    	
        $this->_helper->layout->disableLayout();
    	 
    	header("Content-Disposition: inline; filename=Service-Report-".$service->id.'.pdf');
    	header("Content-type: application/x-pdf");
    	
    	echo $pdf;
    	
    	exit();
    }


}

