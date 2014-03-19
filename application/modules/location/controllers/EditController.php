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
 * @category   Location
 * @package    Controller
 * @copyright  Copyright (c) 2013 Jaimie Garner I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Location_EditController extends Zend_Controller_Action
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
    	
    	$formModel = new Location_Form_Edit();
    	$form = $formModel->location($location);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$street = $this->getParam('street');
    			$street2 = $this->getParam('street2');
    			$city = $this->getParam('city');
    			$state = $this->getParam('state');
    			$zip = $this->getParam('zip');
    			$status = 1;
    			
    			// check values
    			$cityModel = new City_Model_City();
    			$cityModel->checkValue($city);
    			
    			$stateModel = new State_Model_State();
    			$stateModel->checkValue($state);
    			
    			$locationModel->edit($id, $street, $street2, $city, $state, $zip, $status);
    			
    			// update location search
    			$locationSearchModel = new Location_Model_LocationSearch();
    			$keyword = $street . ' ' . $city;
    			$locationSearchModel->edit($id, $keyword, 'address');
    			
    			
    			
    			$this->redirect('/location/view/index/id/' . $id .'/msg/location-edit');
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	
    	$this->view->form = $form;
    	
    	
    }

    /**
     * Note Action for editing a note
     */
    public function noteAction()
    {
    	$noteId = $this->getParam('id');
    	$locationNoteModel = new Location_Model_LocationNote();
    	$locationNote = $locationNoteModel->loadById($noteId);
    	
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($locationNote->location);
    	$this->view->location = $location;
    	
    	$formModel = new Location_Form_Edit();
    	$form = $formModel->note($locationNote);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$directions = $this->getParam('directions');
    			$note = $this->getParam('note');
    			$access = $this->getParam('access');
    			$boomTruck = $this->getParam('boom_truck');
    			$dog = $this->getParam('dog');
    			$men = $this->getParam('men');
    			$explanation = $this->getParam('explanation');
    			
    			$locationNoteModel->edit($noteId, $directions, $note, $access, $boomTruck, $dog, $men, $explanation);
    			
    			$this->redirect('/location/view/note/id/'.$location->id.'/msg/note-edit');
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

    /**
     * Edits Locations service date
     */
    public function serviceAction()
    {
    	$id = $this->getParam('id');
    	
    	// Load location
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	$this->view->location = $location;
    	
    	// load schedule
    	$scheduleModel = new Schedule_Model_Schedule();
    	$schedule = $scheduleModel->loadByLocation($id);
    	$this->view->schedule = $schedule;
    	
    	$formModel = new Location_Form_Edit();
    	$form = $formModel->service($schedule);
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$date = strtotime($this->getParam('date'));
    			
    			$module = new Schedule_Model_Schedule();
    			if(empty($schedule)) {
    				$module->create($id, $date);
    			} else {
    				$module->edit($schedule->id, $date);
    			}
    			$this->redirect('/location/view/index/id/'.$id.'/msg/schedule-edit');
    			
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    	
    }
}

