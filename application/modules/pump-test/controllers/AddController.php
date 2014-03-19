<?php
/**
 * Quinns Well And Pump
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.i-support-services.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@i-support-services.com so we can send you a copy immediately.
 *
 * @category   PumpTest
 * @package    AddController
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class PumpTest_AddController extends Zend_Controller_Action
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
    		$this->redirect('/pump-test/add/error/msg/no-id');
    	}
    	
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	$this->view->location = $location;
    	
    	$formModel = new PumpTest_Form_Add();
    	$form = $formModel->pumpTest();
    	
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
    			$remarks = $this->getParam('remarks');
    			
    			// find ownerid
    			$ownerModel = new Owner_Model_Owner();
    			$owner = $ownerModel->loadByName($owner);
    			$ownerId = $owner->id;
    			
    			// create test
    			$pumpTestModel = new PumpTest_Model_PumpTest();
    			$pumpTestId = $pumpTestModel->create($id,$ownerId,$requirements,$source,$depth,$diameter, 
    					$equipment,$level,$vent,$seal,$popOffValve,$color,$taste,$odor,$employee,$remarks,$date);
    			
    			$this->redirect('/pump-test/add/data/id/' .$pumpTestId.'/start/'.$startTime);
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    	
    }
    
    /**
     * Flow Data Page
     */
    public function dataAction()
    {
    	$pumpTestId = $this->getParam('id');
    	if($pumpTestId < 1){
    		$this->redirect('/pump-test/add/error/msg/no-pump-test-id');
    	}
    	
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadById($pumpTestId);
    	if(empty($pumpTest)) {
    		$this->redirect('/pump-test/add/error/msg/no-pump-test');
    	}
    	$this->view->pumpTest = $pumpTest;
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pumpTest->location);
    	if(empty($location)){
    		$this->rediect('/pump-test/add/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	// add msg
    	$this->view->msg = $this->getParam('msg');
    		
    	$startTime = (int)$this->getParam('start');
    	if(empty($startTime)){
    		$this->redirect('/pump-test/add/error/msg/no-start-time');
    	}
    	
    	// add 4 hours 
    	$endTime = $startTime + 14400;
    	
    	
    	$timeConvert = new Application_Model_TimeConvert();
    	$startTime = $timeConvert->time_to_decimal(date("H:i:s",$startTime));
    	$endTime = $timeConvert->time_to_decimal(date("H:i:s",$endTime));
    	
    	$this->view->startTime = $startTime;
    	$this->view->endTime = $endTime;
    	
    	$formModel = new PumpTest_Form_Add();
    	$form = $formModel->data($startTime, $endTime);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$pumpFlowModel = new PumpTest_Model_PumpFlow();
    			
    			$count = 0;
    			for($i=$startTime*60; $i<=$endTime*60; $i+=15) {
    				$flow = $this->getParam('flow'.$count);
    				$static = $this->getParam('static'.$count);
    				$time = $this->getParam('time'.$count);
    				
    				$id = $pumpFlowModel->create($pumpTestId, $flow, $static, $time);
    				
    				$count++;
    			}
    			
    			$this->redirect('/pump-test/view/index/id/'.$pumpTestId.'/msg/pump-test-add');
    			
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

