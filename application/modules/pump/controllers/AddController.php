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
 * @category   Pump
 * @package    AddController
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Pump_AddController extends Zend_Controller_Action
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
    	 
    	// Load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	$this->view->location = $location;
    	
    	// load Well log and search for a record
    	$wellLogModel = new Well_Model_WellLog();
    	$wellLog = $wellLogModel->loadByAddress($location->street);
    	$this->view->wellLog = $wellLog;
    	
    	$formModel = new Pump_Form_Add();
    	if(!empty($wellLog)) {
    	$form = $formModel->pump($wellLog->completed_depth,$wellLog->well_tag_nbr,$wellLog->post_static_water_level,
    			$wellLog->use,$wellLog->max_yield);
    	} else {
    		$form = $formModel->pump('','','','','');
    	}
    	
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
    			$staticLevel = $this->getParam('static_level', 'Unknown');
    			$yield = $this->getParam('yield', 'Unknown');
    			$tankModel = $this->getParam('tank_model', 'Unknown');
    			$tankType = $this->getParam('tank_type', 'Unknown');
    			$tankSize = $this->getParam('tank_size', 'Unknown');
    			$filtration = $this->getParam('filtration', 'Unknown');
    			
    			// Load Models
    			$pumpModelModel = new PumpModel_Model_PumpModel();
    			$pumpTypeModel = new PumpType_Model_PumpType();
    			$pipeModel = new Pipe_Model_Pipe();
    			$tankSizeModel = new TankSize_Model_TankSize();
    			$tankModelModel = new TankModel_Model_TankModel();
    			$tankTypeModel = new TankType_Model_TankType();
    			$filtrationModel = new Filtration_Model_Filtration();
    			$pumpModelClass = new Pump_Model_Pump();
    			$tankModelClass = new Tank_Model_Tank();
    			
    			// check fields for new values
    			$pumpModelModel->checkValue($pumpModel);
    			$pumpTypeModel->checkValue($pumpType);
    			$pipeModel->checkValue($pipe);
    			$tankSizeModel->checkValue($tankSize);
    			$tankModelModel->checkValue($tankModel);
    			$tankTypeModel->checkValue($tankType);
    			$filtrationModel->checkValue($filtration);
    			
    			// create pump
    			$pumpId = $pumpModelClass->create($id, $pumpModel, $pumpType, $voltage, $phase, $wire, $pipe,
    					 $pipeSize, $wellDepth, $pumpDepth,$use,$yield,$pumpTag,$staticLevel,1);
    			
    			// create tank
    			$tankModelClass->create($pumpId, $tankSize, $tankType, $tankModel, $filtration);
    			
    			    			
    			$this->redirect('/pump/view/index/id/'.$pumpId.'/msg/pump-add');
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }


}

