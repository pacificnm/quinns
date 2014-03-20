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


class PumpTest_DeleteController extends Zend_Controller_Action
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
    	
    	// load pump test
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadById($id);
    	$this->view->pumpTest = $pumpTest;
    	
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pumpTest->location);
    	$this->view->location = $location;
    	
    	$form = new PumpTest_Form_Delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    		    $PumpTestModelPumpFlow = new PumpTest_Model_PumpFlow();
    		    
    		    $pumpTestModel->delete($id);
    		    
    		    $PumpTestModelPumpFlow->delete($id);
    		    
    		    $this->redirect('/location/view/index/id/' . $id .'/msg/location-edit');
    		}
    	}
    	
    	$this->view->form = $form;
    }


}

