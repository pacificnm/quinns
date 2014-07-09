<?php
class ImportController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}

	public function newcliAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit','1600M');
		 
		$wellModel = new Well_Model_Well();
		$oldWellData = $wellModel->loadOldData();
		
		foreach($oldWellData as $well){

			$street = ucwords(strtolower($well->Address));
			$street2 = '';
			$city = ucwords(strtolower($well->City));
			$state = ucwords(strtolower($well->State));
			$zip = $well->Zip;
			$status = 1;
			
			if(!empty($street)) {
				
				@ob_end_clean();
				ob_start();
				
				echo "Working on address $street \n";
				
				if(empty($city)) $city = 'Grants Pass';
				if(empty($state)) $state = 'Or';
				if(empty($zip)) $zip = '97526';
				
				$locationModel = new Location_Model_Location();
				
				$id = $locationModel->create($street, $street2, $city, $state,$zip, $status);
				
				echo "Created Well #$id \n";
				
				ob_end_flush();
				flush();
			}
			
		}
		
	}
	
	public function mapAction()
	{
	    $this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    
	    ini_set('max_execution_time', 0);
	    ini_set('memory_limit','1600M');
	    
	    $locationModel = new Location_Model_Location();
	    $locations = $locationModel->loadEmptyLat(1000);
	    
	    $googleModel = new Application_Model_GoogleMaps();
	    $origin = '6811 Williams Hwy, Grants Pass, OR 97527';
	    
	    $geoModel = new Geo_Model_Geo();
	    
	    foreach($locations as $location) {
	        @ob_end_clean();
	        ob_start();
	        echo "Working on Location " . $location->street . ' ' . $location->city.'<br />';
	        
	        
	        $destination = $location->street .', ' . $location->city . ', ' . $location->state .', ' . $location->zip;
	        $map = $googleModel->getDirections($origin, $destination);
	        
	        
	        if($googleModel->getStatus()  == 'OK'){
	            
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
    		   
    		   
    		    // save driving directions
    		    echo "Saved driving directions <br>";
	            $geoModel->create($location->id, $distance, $duration, $html);
	            
	            // update location
	            echo "Updated locaotion and added LAT and LNG<br />";
	            $locationModel->addLatLng($location->id, $lat, $lng);
	            
	        // failed to find location using google mark it failed.    
	        } else {
	           echo "Failed to find lat and lng <br />";
	          
	           $data = array('lat_fail' => 1);
	           $where = $locationModel->getTable()->getDefaultAdapter()->quoteInto('id = ?', $location->id);
	           $locationModel->getTable()->update($data, $where);   
	        }
	        ob_end_flush();
	        flush();
	    }
	}
	
	public function cliAction()
	{
		$this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','1600M');
         
        $wellModel = new Well_Model_Well();
        $oldWellData = $wellModel->loadOldData();
         
        foreach($oldWellData as $well){
        
        
        
        	$street = ucwords(strtolower($well->Address));
        	$street2 = '';
        	$city = ucwords(strtolower($well->City));
        	$state = ucwords(strtolower($well->State));
        	$zip = $well->Zip;
        
        	$status = 1;
        
        	if(!empty($street)) {
        		// check welllog table
        		$wellogs = $wellModel->searchByAddress($street);
        		 
        		if(!empty($wellogs)) {
        		
        			foreach($wellogs as $wellog){
        				@ob_end_clean();
        				ob_start();
        				
        				echo "Working on address $street \n";
        		   
        				$depth = (int)$wellog->DEPTH;
        				$caseDepth = (int)$wellog->CASE_DEPTH;
        				$staticLevel = (int)$wellog->STATIC_LEV;
        		   
        				// Township data
        				$twn = $wellog->TWN;
        				$rng = $wellog->RNG;
        				$sec = $wellog->SEC;
        				$qs = $wellog->QS;
        				$qq = $wellog->QQ;
        		   
        				// tax lot and well number
        				$taxLot = $wellog->TAX_LOT;
        				$wellNo = $wellog->WELL_NO_;
        		   
        				// fix date
        				if(empty($date)) {
        					$date = time();
        				} else {
        					$date = strtotime($wellog->DATE);
        				}
        				if(!is_int($date)) $date = time();
        		   
        				// fix empty fields
        				if(empty($zip)) $zip = '97526';
        				if(empty($depth)) $depth = 0;
        				if(empty($caseDepth)) $caseDepth = 0;
        				if(empty($staticLevel)) $staticLevel = 0;
        				if(empty($city)) $city = 'Grants Pass';
        				if(empty($state)) $state = 'Or';
        		   
        				$id = $wellModel->create($street,$street2,$city,$state,$zip,
        						$depth,$caseDepth,$staticLevel,$date,$status,$twn,$rng,$sec,$qs,$qq,
        						$taxLot,$wellNo);
        		   
        				echo "Created Well #$id \n";
        
        				ob_end_flush();
        				flush();
        			}
        
        
        		} else {
        			echo 'No Log found <br />';
        		}
        	}
        	 
        	//echo 'No Street Found <br />';
        	// street is empty
        
        }
	}

}