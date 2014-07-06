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


class Pump_DeleteController extends Zend_Controller_Action
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
        $pumpId = $this->getParam('pump_id');
        
        if($pumpId < 1) {
            throw new Zend_Exception('missing required param pump_id');
        }
        
        // load pump
        $pumpModel = new Pump_Model_Pump();
        $pump = $pumpModel->loadById($pumpId);
        $this->view->pump = $pump;
        
        // load location
        $locationModel = new Location_Model_Location();
        $location = $locationModel->loadById($pump->location);
        $this->view->location = $location;
        
        $formModel = new Pump_Form_Delete();
        $form = $formModel->pump();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                
                $pumpModel->delete($pumpId);
                
                $this->redirect('/location/view/index/id/' . $pump->location);
                
            }else {
    			$form->highlightErrorElements();
    		}
        }
        
        $this->view->form = $form;
    }


}

