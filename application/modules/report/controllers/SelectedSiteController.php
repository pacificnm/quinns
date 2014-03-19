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
 * @category   Report
 * @package    SelectedSiteController
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Report_SelectedSiteController extends Zend_Controller_Action
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Controller_Action::init()
	 */
    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * View all Selected sites reports
     */
    public function indexAction()
    {
    	// load employee
    	$authModel = Zend_Auth::getInstance();
    	$auth = $authModel->getIdentity();
    	$employeeId = $auth['employeeId'];
    	
    	
    	$formModel = new Report_Form_Search();
    	$form = $formModel->sites();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$ownerId		= $this->getParam('owner_id');
    			$name 			= $this->getParam('name');
    			$phone 			= $this->getParam('phone');
    			$email 			= $this->getParam('email');
    			$ownerStreet 	= $this->getParam('owner_street');
    			$ownerCity 		= $this->getParam('owner_city');
    			$ownerState 	= $this->getParam('owner_state');
    			$ownerZip 		= $this->getParam('owner_zip');
    			
    			$limit 			= $this->getParam('records');
    			
    			$ownerModel = new Owner_Model_Owner();
    			$check = $ownerModel->loadByName($name);
    			
     			// check if we got an owner id
     			if($check->id < 1) {
     				
     				$ownerId = $ownerModel->create($name,$ownerStreet,'',$ownerCity,$ownerState,$ownerZip,$phone, 
     						$email, 1);
     			} else {
     				$ownerId = $check->id;
     			}
    			
     			$latitude  = $this->getParam('latitude');
     			$longitude = $this->getParam('longitude');
     			
     			if( !empty($latitude) or !empty($longitude) ) {
     				$error = false;
     				
     				// check that both fields have data
     				if(empty($latitude)) {
     					$element = $form->getElement('latitude');
     					$glass  = $element->getAttrib('class');
						$element->setDecorators(array(
								'ViewHelper',
								'Description',
								array('HtmlTag', array('tag' => 'div')),
								array('Label', array('tag' => 'div', 'class' => 'error')),
							));
						$element->setAttrib('class', $glass . ' error');
						$element->addError('Field Latitude is required if you are searching by Latitude and Longitude.');
     				
						$error = true;
     				}
     				
     				if(empty($longitude)) {
     					$element = $form->getElement('longitude');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					$element->addError('Field Longitude is required if you are searching by Latitude and Longitude.');
     					$error = true;
     				}
     				
     				if(!$error){
     					// search lat and long
     					$wellLogModel = new Well_Model_WellLog();
     					$wellLogs = $wellLogModel->loadByLatLon($latitude, $longitude, $limit);
     					
     					// create site report
     					$search = $latitude . ' ' . $longitude;
     					$selectedSiteModel = new SelectedSite_Model_SelectedSite();
     					$selectedSiteId = $selectedSiteModel->create($ownerId, $employeeId, time(), $search);
     					
     					$selectedSiteDataModel = new SelectedSite_Model_SelectedSiteData();
     					
     					foreach($wellLogs as $log) {
     						
     						$selectedSiteDataModel->create($selectedSiteId, $log['id'], $log['search_distance']);
     					}
     					
     					$this->redirect('/report/selected-site/view/id/' . $selectedSiteId);
     				}
     			} // ends of lat lon search
     			
     			
     			// address search
     			
     			$street = $this->getParam('street');
     			$city   = $this->getParam('city');
     			 
     			if(!empty($street)) {
     				
     				$wellLogModel = new Well_Model_WellLog();
     				$wellLog = $wellLogModel->loadByAddress($street);
     				
     				
     				if(empty($wellLog)) {
     					
     					$element = $form->getElement('street');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					$element->addError('We could not find a well log with the address you provided. The state Well Logs did not keep very good records of Address try searching using the PLSS system instead. You could also try changing the street number.');
     					
     					$element = $form->getElement('city');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					
     					$error = true;
     					
     				} else {
     					
     					// we found a result
     					$latitude		= $wellLog->latitude;
     					$longitude		= $wellLog->longitude;
     					$search			= $street .' ' . $city;
     					
     					
     					$wellLogModel = new Well_Model_WellLog();
     					$wellLogs = $wellLogModel->loadByLatLon($latitude, $longitude, $limit);
     					
     					$selectedSiteModel = new SelectedSite_Model_SelectedSite();
     					$selectedSiteId = $selectedSiteModel->create($ownerId, $employeeId, time(), $search);
     					
     					$selectedSiteDataModel = new SelectedSite_Model_SelectedSiteData();
     					foreach($wellLogs as $log) {
     							
     						$selectedSiteDataModel->create($selectedSiteId, $log['id'], $log['search_distance']);
     					}
     					
     					$this->redirect('/report/selected-site/view/id/' . $selectedSiteId);
     				}
     				
     				
     			}
     			// end of Address Search
     			
     			
     			// plss search
     			$township 		= ltrim($this->getParam('township'), '0');
     			$townshipChar 	= $this->getParam('township_char');
     			$range 			= ltrim($this->getParam('range'), '0');
     			$rangeChar 		= $this->getParam('range_char');
     			$sctn			= ltrim($this->getParam('sctn'), '0');
     			$sctnDivision	= $this->getParam('sctn_division');
     			
     			if(!empty($township) or !empty($range) or !empty($sctn) or !empty($sctnDivision)) {
     				
     				// check fields
     				$error = false;
     				
     				
     				if(empty($township)) {
     					$element = $form->getElement('township');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					$element->addError('Field Township is required if you are searching by PLSS System.');
     					$error = true;
     				}
     				
     				if(empty($range)) {
     					$element = $form->getElement('range');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					$element->addError('Field Range is required if you are searching by PLSS System.');
     					$error = true;
     				}
     				
     				if(empty($sctn)) {
     					$element = $form->getElement('sctn');
     					$glass  = $element->getAttrib('class');
     					$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
     					));
     					$element->setAttrib('class', $glass . ' error');
     					$element->addError('Field Section is required if you are searching by PLSS System.');
     					$error = true;
     				}
     				
     				if(!$error) {
     					$wellLogModel = new Well_Model_WellLog();
     					$wellLog = $wellLogModel->loadByPlss($township, $townshipChar, $range, $rangeChar, $sctn);
     					
     					
     					
     					if(empty($wellLog)) {
     						
     						$element = $form->getElement('township');
     						$glass  = $element->getAttrib('class');
     						$element->setDecorators(array(
     							'ViewHelper',
     							'Description',
     							array('HtmlTag', array('tag' => 'div')),
     							array('Label', array('tag' => 'div', 'class' => 'error')),
	     					));
	     					$element->setAttrib('class', $glass . ' error');
	     					$element->addError('Invalid PLSS Search. We could not find any records with the information you provided.');
	     					
	     					$element = $form->getElement('township_char');
	     					$element->setAttrib('class', 'error');
	     					
	     					$element = $form->getElement('range');
	     					$element->setAttrib('class', 'error');
	     					
	     					$element = $form->getElement('range_char');
	     					$element->setAttrib('class', 'error');
	     					
	     					$error = true;
     					} else {
     						// no error create report
     						$selectedSiteModel = new SelectedSite_Model_SelectedSite();
     						$search = $township.' '.$townshipChar.' '.$range.' '.$rangeChar.' '.$sctn.' '.$sctnDivision;
     						
     						$selectedSiteId = $selectedSiteModel->create($ownerId, $employeeId, time(), $search);
     						
     						$selectedSiteDataModel = new SelectedSite_Model_SelectedSiteData();
     						
     						$wellLogModel = new Well_Model_WellLog();
     						$wellLogs = $wellLogModel->loadByLatLon($wellLog->latitude, $wellLog->longitude, $limit);
     						
     						foreach($wellLogs as $log) {
     								
     							$selectedSiteDataModel->create($selectedSiteId, $log['id'], $log['search_distance']);
     						}
     						
     						// redirect to view report
     						$this->redirect('/report/selected-site/view/id/' . $selectedSiteId);
     					}
     					
     				}
     			}
     			
     			
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	} 
    	$this->view->form = $form;
    }

    /**
     * View All Selected sites reports
     */
    public function allAction()
    {
    	$selectedSiteModel = new SelectedSite_Model_SelectedSite();
    	$selectedSites = $selectedSiteModel->loadAll();
    	$this->view->selectedSites = $selectedSites;

    	$this->view->msg = $this->getParam('msg');
    }

    public function viewAction()
    {
    	$selectedSiteId = $this->getParam('id');
    	
    	$selectedSiteModel = new SelectedSite_Model_SelectedSite();
    	$selectedSite = $selectedSiteModel->loadById($selectedSiteId);
    	$this->view->selectedSite = $selectedSite;
    	
    	
    	// load data
    	$selectedSiteDataModel = new SelectedSite_Model_SelectedSiteData();
    	$selectedSiteData = $selectedSiteDataModel->loadBySelectedSiteId($selectedSiteId);
    	$this->view->selectedSiteData = $selectedSiteData;
    	
    	/**
    	print_r($selectedSiteData);
    	die;
    	*/
    	
    	$this->view->msg = $this->getParam('msg');
    }
    
    /**
     * Deletes a selected site report
     */
    public function deleteAction()
    {
    	$id = $this->getParam('id');
    	$selectedSiteModel = new SelectedSite_Model_SelectedSite();
    	$selectedSite = $selectedSiteModel->loadById($id);
    	
    	
    	
    	$this->view->selectedSite = $selectedSite;
    	
    	$formModel = new SelectedSite_Form_Delete();
    	
    	$form = $formModel->delete();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$selectedSiteModel->remove($id);
    			
    			$this->redirect('/report/selected-site/all/msg/delete-ok');
    		} else {
    			$form->highlightErrorElements();
    		}
    	} 
    	$this->view->form = $form;
    }
    
    
    
    public function printAction()
    {
    	$id = (int)$this->getParam('id');
    	
    	$selectedSiteModel = new SelectedSite_Model_SelectedSite();
    	$selectedSite = $selectedSiteModel->loadById($id);
    	
    	// load data
    	$selectedSiteDataModel = new SelectedSite_Model_SelectedSiteData();
    	$selectedSiteData = $selectedSiteDataModel->loadBySelectedSiteId($id);  	
    	
    	$pdfModel = new Report_Model_Pdf();
    	
    	$pdf = $pdfModel->selectedSite($selectedSite,$selectedSiteData);
    	
    	
    	$this->_helper->layout->disableLayout();
    	 
    	header("Content-Disposition: inline; filename=Service-Report-".$service->id.'.pdf');
    	header("Content-type: application/x-pdf");
    	
    	echo $pdf;
    	
    	exit();
    }
}

