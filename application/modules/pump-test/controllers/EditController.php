<?php
/**
 * PumpTest Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package PumpTest
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class PumpTest_EditController extends Zend_Controller_Action
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
    	
    	if($id < 1){
    		$this->redirect('/pump-test/edit/error/msg/missing-id');
    	}
    	
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadById($id);
    	if(empty($pumpTest)){
    		$this->redirect('/pump-test/edit/error/msg/no-pumptest-found');
    	}
    	$this->view->pumpTest = $pumpTest;
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pumpTest->location);
    	$this->view->location = $location;
    	
    	
    	$formModel = new PumpTest_Form_Edit();
    	$form = $formModel->pumpTest($pumpTest);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			 
    			$requirements = $this->getParam('requirements');
    			$source = $this->getParam('source');
    			$depth = $this->getParam('depth');
    			$diameter = $this->getParam('diameter');
    			$equipment = $this->getParam('equipment');
    			$level = $this->getParam('level');
    			$vent = $this->getParam('vent');
    			$seal = $this->getParam('seal');
    			$popOffValve = $this->getParam('pop_off_valve');
    			$color = $this->getParam('color');
    			$taste = $this->getParam('taste');
    			$odor = $this->getParam('odor');
    			$employee = $this->getParam('employee');
    			$owner = $this->getParam('owner');
    			$date = strtotime($this->getParam('date'));
    			$startTime = $this->getParam('start_time');
    			$endTime = $this->getParam('end_time');
    			$remarks = $this->getParam('remarks');
    			 
    			// find ownerid
    			$ownerModel = new Owner_Model_Owner();
    			$owner = $ownerModel->loadByName($owner);
    			$ownerId = $owner->id;
    			 
    			// create test
    			$pumpTestModel = new PumpTest_Model_PumpTest();
    			$pumpTestModel->edit($id,$ownerId,$requirements,$source,$depth,$diameter,$equipment,$level,$vent, 
    					$seal,$popOffValve,$color,$taste,$odor,$employee,$remarks,$date);
    			 
    			$this->redirect('/pump-test/view/index/id/'.$id.'/msg/edit-ok');
    			 
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }


    public function flowAction()
    {
    	$id = (int)$this->getParam('id');
    	 
    	if($id < 1){
    		$this->redirect('/pump-test/edit/error/msg/missing-id');
    	}
    	 
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadById($id);
    	if(empty($pumpTest)){
    		$this->redirect('/pump-test/edit/error/msg/no-pumptest-found');
    	}
    	$this->view->pumpTest = $pumpTest;
    	 
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pumpTest->location);
    	$this->view->location = $location;
    	
    	// load flow data
    	$pumpFlowModel = new PumpTest_Model_PumpFlow();
    	$pumpFlow = $pumpFlowModel->loadByTest($pumpTest->id);
    	$this->view->pumpFlow = $pumpFlow;
    	
    	$formModel = new PumpTest_Form_Edit();
    	$form = $formModel->flow($pumpFlow);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			foreach($pumpFlow as $data) {
    				$flow = $this->getParam('flow'.$data->id);
    				$static = $this->getParam('static'.$data->id);
    				
    				$pumpFlowModel->edit($data->id,$flow,$static);
    			}
    			
    			$this->redirect('/pump-test/view/index/id/' . $id . '/msg/edit-pump-test-data');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }
}

