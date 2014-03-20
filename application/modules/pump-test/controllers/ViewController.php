<?php

class PumpTest_ViewController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = (int)$this->getParam('id');
        
        // load pump test
        $pumpTestModel = new PumpTest_Model_PumpTest();
        $pumpTest = $pumpTestModel->loadById($id);
        $this->view->pumpTest = $pumpTest;
        
        
        // load location
        $locationModel = new Location_Model_Location();
        $location = $locationModel->loadById($pumpTest->location);
        $this->view->location = $location;
        
        
        // load flow
        $pumpFlowModel = new PumpTest_Model_PumpFlow();
        $pumpFlow = $pumpFlowModel->loadByTest($pumpTest->id);
        $this->view->pumpFlow = $pumpFlow;
        
        
        if(count($pumpFlow) == 0) {
            $formModel = new PumpTest_Form_Add();
            $this->view->form = $formModel->flow($id);
            
            if ($this->getRequest()->isPost()) {
                $startTime = $this->getParam('start_time');
                $this->redirect('/pump-test/add/data/id/' .$id.'/start/'.$startTime);
            }
        }
        
        
        $this->view->msg = $this->getParam('msg');
       
    }


    public function allAction()
    {
    	$id = (int)$this->getParam('id');
    	
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	$this->view->location = $location;
    	
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTests = $pumpTestModel->loadByLocation($id);
    	$this->view->pumpTests = $pumpTests;
    }
}

