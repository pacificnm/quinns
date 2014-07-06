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


class Location_AddController extends Zend_Controller_Action
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
    	
    	$street = urldecode($this->getParam('street'));
    	
    	
    	// see if we can find well log
    	$wellLogModel = new Well_Model_WellLog();
    	
    	if(!empty($street)) {
    		$wellLog = $wellLogModel->loadByAddress($street);
    		$this->view->wellLog = $wellLog;
    	}
    	
    	
    	$formModel = new Location_Form_Add();
    	if(!empty($wellLog)) {
    		$form = $formModel->location($street,$wellLog->city,$wellLog->state,$wellLog->zip,$wellLog->township,
    				$wellLog->township_char,$wellLog->range,$wellLog->range_char,$wellLog->sctn);
    	} else {
    		$form = $formModel->location($street,'','','','','','','','');
    	}
    	
    	
    	$locationModel = new Location_Model_Location();
    	$locationNoteModel = new Location_Model_LocationNote();
    	$locationSearchModel = new Location_Model_LocationSearch();
    	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($this->getRequest()->getPost())) {
    			$street = $this->getParam('street');
    			$street2 = $this->getParam('street2');
    			$city = $this->getParam('city');
    			$state = $this->getParam('state');
    			$zip = $this->getParam('zip');
    			
    			$township = $this->getParam('township');
    			$townshipChar = $this->getParam('township_char');
    			$range = $this->getParam('range');
    			$rangeChar = $this->getParam('range_char');
    			$sctn = $this->getParam('sctn');
    			
    			// create location
    			$locationId = $locationModel->create($street, $street2, $city, $state, $zip, 1, 'NULL');
    			
    			// create location note
    			$locationNoteId = $locationNoteModel->create($locationId, '', '', '', 0, 0, 1, '');
    			
    			// create search fields
    			$locationSearchId = $locationSearchModel->create($locationId, $street,'address');
    			
    			$keyword = (int)$township.' '.$townshipChar.' '.(int)$range.' '.$rangeChar.' '.(int)$sctn;
    			$locationSearchId = $locationSearchModel->create($locationId, $keyword,'plss');
    			
    			// create next service date
    			$scheduleModel = new Schedule_Model_Schedule();
    			$serviceDue = strtotime('+1 month', time());
    			$scheduleModel->create($locationId, $serviceDue);
    			
    			$this->redirect('/owner/add/index/location_id/'.$locationId.'/well-log/'.$wellLog->id.'/msg/location-add');
    			
    		} else {
    			$form->highlightErrorElements();
    		}
    	}
    	$this->view->form = $form;
    }

    
    /**
     * Add Maps info
     */
    public function mapAction()
    {
    	$id = (int)$this->getParam('id');
    	if($id < 1){
    		$this->redirect('/location/add/error/msg/no-id');
    	}
    	
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadById($id);
    	if(empty($location)){
    		$this->redirect('/location/add/error/msg/no-location');
    	}
    	$this->view->location = $location;
    	
    	// load Google Model
    	$googleModel = new Application_Model_GoogleMaps();
    	$origin = '6811 Williams Hwy, Grants Pass, OR 97527';
    	$destination = $location->street .', ' . $location->city . ', ' . $location->state .', ' . $location->zip;
    	$map = $googleModel->getDirections($origin, $destination);
    
    	
    	if($googleModel->getStatus()  == 'OK'){
    		$this->view->googleStatus = 'OK';
    		
    		$duration = $googleModel->getDuration();
    		$distance = $googleModel->getDistance();
    		$lat = $googleModel->getLat();
    		$lng = $googleModel->getLon();
    		$directions = $googleModel->getDrivingDirections();
    		
    		$html = '';
    		foreach($directions[0]['steps'] as $map) {
    			$html .= '<b>Distance: </b> ' .$map['distance']['text'].' <b>Duration:</b> '.$map['duration']['text'];
    			$html .= ' <b>Directions: </b> '.$map['html_instructions'].'<br />';
    		}
    		
    		$this->view->duration = $duration;
    		$this->view->distance = $distance;
    		$this->view->lat = $lat;
    		$this->view->lng = $lng;
    		$this->view->directions = $html;
    		
    		// check blm
    		$url = 'http://www.geocommunicator.gov/TownshipGeocoder/TownshipGeocoder.asmx/GetTRSFeed?Lat='.$lat.'&Lon='.$lng.'&Units=eDD&Datum=NAD27';
    			
    		$xml = simplexml_load_file($url);
    			
    		$chunk = $xml->channel->item[1];
    			
    		$pieces = explode(',', $chunk->description);
    			
    		$township 		= $pieces[2];
    		$townshipChar 	= $pieces[4];
    		$rang 			= $pieces[5];
    		$rangChar 		= $pieces[7];
    		$section 		= $pieces[8];
    		$division 		= $pieces[9];
    		
    		$this->view->plss = $township . ' ' . $townshipChar . ' ' . $rang . ' ' . $rangChar . ' ' . $section . ' ' . $division;
    		
    	} else {
    		$this->view->googleStatus = 'FAIL';
    	}

    	
    	// If we post the data back we will save it.
    	if ($this->getRequest()->isPost()) {
    		
    		$locationSearchModel = new Location_Model_LocationSearch();
    		
    		// save lat Lon
    		$keyword = $lat . ' ' . $lng;
    		$locationSearchModel->create($id, $keyword, 'lat');
    		
    		// save PLSS
    		$keyword = $township . ' ' . $townshipChar . ' ' . $rang . ' ' . $rangChar . ' ' . $section . ' ' . $division;
    		$locationSearchModel->create($id, $keyword, 'plss');
    		
    		// add driving directions
    		$geoModel = new Geo_Model_Geo();
    		$geoModel->create($id, $distance, $duration, $html);
    		
    		// update location
    		$locationModel->addLatLng($id, $lat, $lng);
    		$locationModel->addPlls($id, $township, $townshipChar, $rang, $rangChar, $section, $division);
    		
    		$this->redirect('/location/view/map/id/' .$id.'/msg/add-map');
    		
    	}
    }

}

