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


class Pump_ViewController extends Zend_Controller_Action
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
    	$pumpModel = new Pump_Model_Pump();
    	$pump = $pumpModel->loadById($id);
    	$this->view->pump = $pump;
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($pump->location);
    	$this->view->location = $location;
    	
    	// load pumptest
    	$pumpTestModel = new PumpTest_Model_PumpTest();
    	$pumpTest = $pumpTestModel->loadByLocation($id);
    	$this->view->pumpTest = $pumpTest;
    	$this->view->pumpTestCount = count($pumpTest);
    	
    	// load tank
    	$tankModel = new Tank_Model_Tank();
    	$tank = $tankModel->loadByPump($pump->id);
    	$this->view->tank = $tank;
    	
    	$msg = $this->getParam('msg');
    	$this->view->msg = $msg;
    	
    	
    }


}

