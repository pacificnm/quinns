<?php
/**
 * Pump Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pump
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Pump_EditController extends Zend_Controller_Action
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
    	 
    	// loadpump
    	$pumpModelClass = new Pump_Model_Pump();
    	$pump = $pumpModelClass->loadById($id);
    	$this->view->pump = $pump;
    	 
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pump->location);
    	$this->view->location = $location;
    	
    	// load tank
    	$tankModelClass = new Tank_Model_Tank();
    	$tank = $tankModelClass->loadByPump($pump->id);
    	$this->view->tank = $tank;
    	
    	$formModel = new Pump_Form_Edit();
    	$form = $formModel->pump($pump,$tank);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			
    			$pumpModel = $this->getParam('pump_model', 'Unknown');
    			$pumpType = $this->getParam('pump_type', 'Unknown');
    			$wellDepth = $this->getParam('well_depth', 'Unknown');
    			$pumpDepth = $this->getParam('pump_depth', 'Unknown');
    			$voltage = $this->getParam('voltage', 'Unknown');
    			$phase = $this->getParam('phase', 'Unknown');
    			$wire = $this->getParam('wire', 'Unknown');
    			$pipe = $this->getParam('pipe', 'Unknown');
    			$pipeSize = $this->getParam('pipe_size', 'Unknown');
    			$pumpTag = $this->getParam('pump_tag', 'Unknown');
    			$use = $this->getParam('use', 'Unknown');
    			$yield = $this->getParam('yield', 'Unknown');
    			$staticLevel = $this->getParam('static_level', 'Unknown');
    			$tankSize = $this->getParam('tank_size', 'Unknown');
    			$tankModel = $this->getParam('tank_model', 'Unknown');
    			$tankType = $this->getParam('tank_type', 'Unknown');
    			
    			$filtration =  $this->getParam('filtration', 'Unknown');
    			
    			// Load Models
    			$pumpModelModel = new PumpModel_Model_PumpModel();
    			$pumpTypeModel = new PumpType_Model_PumpType();
    			$pipeModel = new Pipe_Model_Pipe();
    			$tankSizeModel = new TankSize_Model_TankSize();
    			$tankModelModel = new TankModel_Model_TankModel();
    			$tankTypeModel = new TankType_Model_TankType();
    			$filtrationModel = new Filtration_Model_Filtration();
    			
    			// check fields
    			$pumpModelModel->checkValue($pumpModel);
    			$pumpTypeModel->checkValue($pumpType);
    			$pipeModel->checkValue($pipe);
    			$tankSizeModel->checkValue($tankSize);
    			$tankModelModel->checkValue($tankModel);
    			$tankTypeModel->checkValue($tankType);
    			$filtrationModel->checkValue($filtration);
    			
    			// update pump
    			$pumpModelClass->edit($id, $pumpModel, $pumpType, $voltage, $phase, $wire, $pipe, 
    					$pipeSize, $wellDepth, $pumpDepth,$pumpTag,$use,$yield,$staticLevel, 1);
    			
    			// update tank
    			$tankModelClass->edit($tank->id, $tankSize, $tankModel, $tankType, $filtration);
    			
    			$this->redirect('/pump/view/index/id/' . $id . '/msg/edit-ok');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}    	
    	$this->view->form = $form;
    }


}

