<?php
/**
 * Location Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Location
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Location_DeleteController extends Zend_Controller_Action
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
    	$id = $this->getParam('location_id');
    	if($id < 1) {
    		throw new Zend_Exception('Missing location id for deletion');
    	}
    	
    	// load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	if(count($location) < 1) {
    		throw new Zend_Exception('Cannot find the location requested');
    	}
    	
    	$formModel = new Location_Form_Delete();
    	$form = $formModel->location();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$locationModel->delete($id);
    			
    			$this->view->hideForm = true;
    			
    		}
    	}
    	

    	$this->view->location = $location;
    	$this->view->form = $form;
    }


}

