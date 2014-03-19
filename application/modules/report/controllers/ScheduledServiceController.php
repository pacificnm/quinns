<?php

class Report_ScheduledServiceController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $page 		= $this->getParam('page');
        
        $form = new Schedule_Form_Search();
        
        $startDate 	= $this->getParam('startDate');
        $endDate 	= $this->getParam('endDate');
         
        $serviceModel = new Service_Model_Service();
        
        if(empty($startDate) or empty($endDate)) {
        	$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
        	$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
        }
         
        
        
        if ($this->getRequest()->isPost()) {
        	if ($form->isValid($this->getRequest()->getPost())) {
        		$startDate = strtotime($this->getParam('postStartDate'));
        		$endDate = strtotime($this->getParam('postEndDate')) + (23 * 3600);
        		
        		print_r($this->getRequest()->getParams());
        		
        		$this->redirect('/report/scheduled-service/index/page/'.$page.'/startDate/'.$startDate.'/endDate/'.$endDate);
        	}
        }
        
        $services = $serviceModel->loadActiveServiceByDate($startDate, $endDate, $page);

        $this->view->startDate 	= $startDate;
        $this->view->endDate 	= $endDate;
        $this->view->form = $form;
        $this->view->services = $services;
    }


}

