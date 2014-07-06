<?php

class Service_Model_Pdf extends Zend_Pdf
{


	public function service($service,$location,$owner,$note,$pump,$geo,$pumpTests, $oldServices,$contacts)
	{
		$pdf = new Zend_Pdf();
		
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		$pageNum = 1;
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		$style = new Zend_Pdf_Style();
		$style->setFont($font, 11);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Service Report', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(1);
		$page->drawLine(10, 806, 592, 806);
		
		
		
		// logo
		$image = Zend_Pdf_Image::imageWithPath(IMAGE_PATH .'/pdf-logo.jpg');
		$page->drawImage($image, 10, 738, 185, 796);
		
		$startLine = 790;
		
		// record id
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service ID:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($service->id, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Street Address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service Address:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->street, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText($location->city .', ' . $location->state .' ' . $location->zip, 320, 754, 'UTF-8');
		
		$startLine-=18;
		
		// owner name
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Name:', 230, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->name, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// billing address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Address:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->street, 320, $startLine, 'UTF-8');
		
		// Scheduled Service
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Scheduled:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y",$service->date), 95, $startLine, 'UTF-8');
		
		
		$startLine-=18;
		
		// start time
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Start Time:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($service->start_time > 0) {
		    $page->drawText(date("H:i A",$service->start_time), 95, $startLine, 'UTF-8');
		} else {
		  $page->drawText("_____________", 95, $startLine, 'UTF-8');
		}
		// billing city
		$page->drawText($owner->city .', ' . $owner->state .' ' . $owner->zip, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		
		// end time
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('End Time:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($service->end_time > 0) {
		    $page->drawText(date("H:i A",$service->end_time), 95, $startLine, 'UTF-8');
		} else {
		    $page->drawText("_____________", 95, $startLine, 'UTF-8');
		}
		
		
		// Telephone
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Phone:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->phone, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// status
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Status:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($service->status, 95, $startLine, 'UTF-8');
		
		
		// loop through contacts 
		$contactLine = $startLine;
		foreach($contacts as $contact) {
		    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		    $page->setFont($font, 11);
		    $page->drawText($contact->owner_type.":", 230, $contactLine, 'UTF-8');
		    
		    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		    $page->setFont($font, 11);
		    $page->drawText($contact->name . " " . $contact->phone, 278, $contactLine, 'UTF-8');
		    
		    $contactLine-=18;
		}
		
		$startLine-=18;
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service Tech:', 10, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if(!empty($service->first_name)) {
			$page->drawText($service->first_name, 95, $startLine, 'UTF-8');
		} else {
			$page->drawText('____________', 95, $startLine, 'UTF-8');
		}
		$startLine-=18;
		
		// adjust line from contacts
		if($contactLine < $startLine) {
		    $startLine = $contactLine;
		}
		
		
		// access
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Access:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->access, 79, $startLine, 'UTF-8');
		
		// Boom Truck
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Boom Truck:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->boom_truck == 1 ? 'Yes' : 'No', 300, $startLine, 'UTF-8');
		
		// dog
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Dog:', 350, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->dog == 1 ? 'Yes' : 'No', 380, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Directions
		if(!empty($note->directions)) {
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Directions:', 10, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$lines = explode("\n",$this->getWrappedText($note->directions,$style,400)) ;
			foreach($lines as $line){
				$page->drawText($line, 79, $startLine);
				if(!empty($line)) {
					$startLine-=18;
				}
			}
		}
		
		// note
		if(!empty($note->note)) {
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Note:', 10, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$lines = explode("\n",$this->getWrappedText($note->note,$style,400)) ;
			foreach($lines as $line){
				$page->drawText($line, 79, $startLine);
				if(!empty($line)) {
						$startLine-=18;
					}
				}
		}
		
		
		// number of men
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('# Men:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->men, 79, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// explanation
		if(!empty($note->explanation)) {
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Explanation:', 10, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$lines = explode("\n",$this->getWrappedText($note->explanation,$style,400)) ;
			foreach($lines as $line){
				$page->drawText($line, 79, $startLine);
				if(!empty($line)) {
						$startLine-=18;
					}
				}
		}
		
		$startLine-=18;
		
		// pump infromation
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Pump Information:', 10, $startLine, 'UTF-8');
		$startLine-=18;
		
		
		if(!empty($pump)) {
			// Pump Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pump_model == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pump_model, 90, $startLine, 'UTF-8');
			}
				
			// Pump Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pump_depth == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pump_depth .' feet', 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
				
			// pump type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pump_type == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pump_type, 90, $startLine, 'UTF-8');
				
			}
				
			// well Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Well Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->well_depth == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->well_depth .' feet', 380, $startLine, 'UTF-8');
			}
			$startLine = $startLine - 18;
				
			// pump_tag
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Well Tag:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pump_tag == 'Unknown' || empty($pump->pump_tag)) {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pump_tag, 90, $startLine, 'UTF-8');
			}
				
			// Tank Size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Size:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->size == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->size, 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
			// volts
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Volts:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->voltage == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->voltage, 90, $startLine, 'UTF-8');
			}
				
			// Tank Type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Type:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->type == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->type, 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
			// Phase
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Phase:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->phase == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->phase, 90, $startLine, 'UTF-8');
			}
				
			// Tank Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Model:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->model == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->model, 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
			// wire
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Wire:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->wire == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->wire, 90, $startLine, 'UTF-8');
			}
				
			// Filtration
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Filtration:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->filtration == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->filtration, 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
			// pipe type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pipe == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pipe, 90, $startLine, 'UTF-8');
			}
				
			//static_level
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Static Level:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->static_level == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->static_level, 380, $startLine, 'UTF-8');
			}	
			$startLine = $startLine - 18;
				
			// pipe size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Size:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->pipe_size == 'Unknown') {
				$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->pipe_size, 90, $startLine, 'UTF-8');
			}
				
			// use
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Water Use:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pump->use == 'Unknown') {
				$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			} else {
				$page->drawText($pump->use, 380, $startLine, 'UTF-8');
			}
			
		} else {
			
			// Pump Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// Pump Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
				
			// pump type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
			
				
			// well Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Well Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
				
			// pump_tag
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Tag:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// Tank Size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Size:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
			// volts
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Volts:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// Tank Type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Type:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
			// Phase
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Phase:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// Tank Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Model:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
			// wire
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Wire:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// Filtration
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Filtration:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
			// pipe type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			//static_level
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Static Level:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
				
			// pipe size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Size:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 90, $startLine, 'UTF-8');
				
			// use
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Water Use:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('__________________________', 380, $startLine, 'UTF-8');
		}
		
		$startLine = $startLine - 18;
		$startLine-=18;
		
		// complaint
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Complaint:',20, $startLine, 'UTF-8');
		
		$startLine-=18;

		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if(!empty($service->complaint)) {		
			$lines = explode("\n",$this->getWrappedText($service->complaint,$style,400)) ;
			foreach($lines as $line){
				$page->drawText($line, 30, $startLine);
				$startLine-=18;
			}
		} else {
			$page->drawText('Unknown', 30, $startLine);
			$startLine-=18;
		}
		
		
		// service performed
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service Performed:',20, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		if(!empty($service->description)) {
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			
			$page->drawText(date("M d, Y",$service->date), 30, $startLine);
			
			$startLine-=18;
			$lines = explode("\n",$this->getWrappedText($service->description,$style,400)) ;
			foreach($lines as $line){
				$page->drawText($line, 30, $startLine);
				$startLine-=18;
			}
		} else {
			
			$page->setLineWidth(0.5);
			
			while ($startLine > 18){
				$page->drawLine(65, $startLine, 580, $startLine);
				$startLine-=18;
			}
		}
		
		
		
		
		// page number and date 
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 9);
		$page->drawText('Page ' . $pageNum . ' Created ' . date("M d, Y", $service->date_created), 265, 18);
		$pdf->pages[] = $page;
		
		
		/**********************************************************
		 * 
		 * Page 2
		 * 
		 * */
		$startLine = 812;
		
		// Old Service Records
		
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		$pageNum = $pageNum + 1;
			
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
		$style = new Zend_Pdf_Style();
		$style->setFont($font, 11);
		
		
		$page->setFont($font, 14);
		$page->drawText('Past Service Records', 250, $startLine, 'UTF-8');
		$startLine-=18;
			
		$page->setLineWidth(1);
		$page->drawLine(10, $startLine, 592, $startLine);
			
		$startLine-=18;
			
			
			
		foreach($oldServices as $oldService) {
			
			if($service->id != $oldService->id and $startLine > 18) {
			
				if(!empty($oldService->description)) {
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText(date("M d, Y",$oldService->date), 30, $startLine);
						
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
						
					$startLine-=18;
					$lines = explode("\n",$this->getWrappedText($oldService->description,$style,400)) ;
					foreach($lines as $line){
						$page->drawText($line, 30, $startLine);
						$startLine-=18;
					}
				}
			}
		}
		
		
		if($service->directions) {
			
			// set title
			$page->setFont($font, 14);
			$page->drawText('Driving Directions', 250, $startLine, 'UTF-8');
			
			$startLine-=18;
			
			// draw line
			$page->setLineWidth(1);
			$page->drawLine(10, $startLine, 592, $startLine);
			
			$startLine-=18;
			
			// directions
			if($geo->id < 1) {
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				$page->drawText('There are no Directions available.', 10, $startLine, 'UTF-8');
			} else {
				$startLine-=18;
				
				// plss
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('PLSS:', 10, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				
				if($location->township < 1) {
					$page->drawText('___________________', 54, $startLine, 'UTF-8');
				} else {
					$page->drawText($location->township.' '.$location->township_char.' '.$location->range.' '.
							 $location->range_char.' '.$location->sctn.' '.$location->division, 48, $startLine, 'UTF-8');
				}
				
				$startLine-=18;
				
				// lat
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('Lat:', 10, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				if(!empty($location->lat)) {
					$page->drawText($location->lat, 54, $startLine, 'UTF-8');
				} else {
					$page->drawText('___________________', 54, $startLine, 'UTF-8');
				}
				
				// lon
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('Lon:', 150, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				if(!empty($location->lng)) {
					$page->drawText($location->lng, 184, $startLine, 'UTF-8');
				} else {
					$page->drawText('___________________', 184, $startLine, 'UTF-8');
				}
				
				$startLine-=18;
				$startLine-=18;
				
				// distance
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('Distance From Office:', 10, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				if(empty($geo->distance)) {
					$page->drawText('Unknown', 128, $startLine, 'UTF-8');
				} else {
					$page->drawText($geo->distance, 128, $startLine, 'UTF-8');
				}
				
				// duration
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('Driving Time:', 170, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				if(empty($geo->duration)) {
					$page->drawText('Unknown', 250, $startLine, 'UTF-8');
				} else {
					$page->drawText($geo->duration, 250, $startLine, 'UTF-8');
				}
				
				$startLine-=18;
				
				// directions
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
				$page->setFont($font, 11);
				$page->drawText('Driving Directions:', 10, $startLine, 'UTF-8');
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 11);
				
				$startLine-=18;
				
				if(!empty($geo->directions)) {
					$lines = explode("\n",$this->getWrappedText(strip_tags(html_entity_decode($geo->directions)),$style,550)) ;
					foreach($lines as $line){
						$page->drawText($line, 30, $startLine);
						$startLine-=18;
					}
				} else {
					$page->drawText('No driving directions avalaible.', 30, $startLine);
				}
				
				$startLine-=18;		
				
			}
		}
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 9);
		$page->drawText('Page  '. $pageNum . ' Created ' . date("M d, Y", $service->date_created), 265, 18);
		if(count($oldServices) > 0) {
		  $pdf->pages[] = $page;
		}
		
		
		
		/**********************************************************
		 *
		* Page 3
		*
		* */
		if($service->flow_test) {

			// flow test
			if(count($pumpTests) > 0) {
				    
				foreach ($pumpTests as $pumpTest) {
				    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
				    $pageNum = $pageNum + 1;
				    
				    // set font
				    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				    
				    $style = new Zend_Pdf_Style();
				    $style->setFont($font, 11);
				    
				    // set title
				    $page->setFont($font, 14);
				    $page->drawText('Flow Test', 250, 812, 'UTF-8');
				    
				    // draw line
				    $page->setLineWidth(1);
				    $page->drawLine(10, 806, 592, 806);
				    
				    $startLine = 790;
				    
				    
					// test date
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Test Date:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText(date("M d, Y",$pumpTest->date), 76, $startLine, 'UTF-8');
			
					// conducted by
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Conducted By:', 160, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->first_name.' '.$pumpTest->last_name , 240, $startLine, 'UTF-8');
			
					$startLine-=18;
			
					// requested by
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Requested By:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->name , 100, $startLine, 'UTF-8');
			
					$startLine-=18;
			
					// requirements
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Test Requirements:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$lines = explode("\n",$this->getWrappedText($pumpTest->requirements,$style,400)) ;
					
					
					
					foreach($lines as $line){
						$page->drawText($line, 137, $startLine);
						$startLine-=18;
					}
					$startLine-=18;
			
					// remarks
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Remarks:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$lines = explode("\n",$this->getWrappedText($pumpTest->remarks,$style,400)) ;
					
					foreach($lines as $line){
						$page->drawText($line, 137, $startLine);
						$startLine-=18;
					}
					
					$startLine-=18;
			
					// requested by
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Equipment Used:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->equipment , 116, $startLine, 'UTF-8');
			
					// source
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Source:', 390, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->source , 435, $startLine, 'UTF-8');
			
					$startLine-=18;
			
					// well depth
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Well Depth:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->depth , 82, $startLine, 'UTF-8');
			
					// pumping level
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Pumping Level:', 116, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->level , 200, $startLine, 'UTF-8');
			
					// case diameter
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Diameter:', 231, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->diameter , 286, $startLine, 'UTF-8');
			
					// seal
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Seal:', 306, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->seal , 334, $startLine, 'UTF-8');
			
					// vent
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Vent:', 364, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->vent , 396, $startLine, 'UTF-8');
			
					// pop off
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Pop Off Valve:', 420, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->pop_off_valve , 498, $startLine, 'UTF-8');
			
					$startLine-=18;
			
					// Water Color
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Water Color:', 20, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->color , 90, $startLine, 'UTF-8');
			
					// tast
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Taste:', 143, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->taste , 178, $startLine, 'UTF-8');
			
					// order
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Odor:', 240, $startLine, 'UTF-8');
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText($pumpTest->odor , 274, $startLine, 'UTF-8');
			
					$startLine-=18;
					$startLine-=18;
			
					// flow data
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
					$page->drawText('Flow Data', 20, $startLine, 'UTF-8');
			
			
			
					$startLine-=18;
			
					$page->drawText('Time', 20, $startLine, 'UTF-8');
					$page->drawText('Flow', 120, $startLine, 'UTF-8');
					$page->drawText('Level', 190, $startLine, 'UTF-8');
					$page->drawText('Meter', 260, $startLine, 'UTF-8');
			
					$page->setLineWidth(0.5);
					$page->drawLine(10, ($startLine -2), 592, ($startLine -2));
			
					$startLine-=18;
			
			
					$flowModel = new PumpTest_Model_PumpFlow();
					$flowData = $flowModel->loadByTest($pumpTest->id);
			
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
			
					$meter = 0;
					$count = 0;
					$flowAverage = 0;
					$averageLevel = 0;
					foreach($flowData as $data) {
						$meter = $meter + ($data->flow * 15);
						$flowAverage =  $flowAverage + $data->flow;
						$averageLevel = $averageLevel + $data->static;
						$count++;
							
						$page->drawText($data->time , 20, $startLine, 'UTF-8');
						$page->drawText($data->flow.' GPM' , 120, $startLine, 'UTF-8');
						$page->drawText($data->static.' feet' , 190, $startLine, 'UTF-8');
						$page->drawText( number_format($meter, 2, '.', '').' Gallons', 260, $startLine, 'UTF-8');
						$startLine-=18;
					}
					$page->setLineWidth(0.5);
					$page->drawLine(10, $startLine, 592, $startLine);
					$startLine-=18;
			
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
					$page->setFont($font, 11);
			
					$page->drawText('Total Time', 20, $startLine, 'UTF-8');
					$page->drawText('Flow Average', 120, $startLine, 'UTF-8');
					$page->drawText('Average Level', 220, $startLine, 'UTF-8');
					$page->drawText('Total Gallons', 320, $startLine, 'UTF-8');
			
					$startLine-=18;
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 11);
					$page->drawText('4 Hours', 20, $startLine, 'UTF-8');
					$page->drawText(number_format($flowAverage / $count, 2, '.', '') . ' GPM', 120, $startLine, 'UTF-8');
					$page->drawText(number_format($averageLevel / $count, 2, '.', '') .' Feet', 220, $startLine, 'UTF-8');
					$page->drawText( number_format($meter, 2, '.', '') . ' Gallons', 320, $startLine, 'UTF-8');
			
					
					$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
					$page->setFont($font, 9);
					$page->drawText('Page  '. $pageNum . ' Created ' . date("M d, Y", $service->date_created), 265, 18);
					$pdf->pages[] = $page;
					
				}
			}
		}
		
		
		
		
		
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Quinns Well Pro';
		$pdf->properties['Title'] = 'Service Report For ' . $location->street . ' Created on ' . date("M d, Y", time());
		$pdf->properties['Subject'] = 'Service Report For ' . $location->street . ' Created on ' . date("M d, Y", time());
		
		
		
		$pdfData = $pdf->render();
		
		return $pdfData;
	}
	
	protected function getWrappedText($string, Zend_Pdf_Style $style,$max_width)
	{
		$wrappedText = '' ;
		$lines = explode("\n",$string) ;
		foreach($lines as $line) {
			$words = explode(' ',$line) ;
			$word_count = count($words) ;
			$i = 0 ;
			$wrappedLine = '' ;
			while($i < $word_count)
			{
				/* if adding a new word isn't wider than $max_width,
				 we add the word */
				if($this->widthForStringUsingFontSize($wrappedLine.' '.$words[$i]
						,$style->getFont()
						, $style->getFontSize()) < $max_width) {
					if(!empty($wrappedLine)) {
						$wrappedLine .= ' ' ;
					}
					$wrappedLine .= $words[$i] ;
				} else {
					$wrappedText .= $wrappedLine."\n" ;
					$wrappedLine = $words[$i] ;
				}
				$i++ ;
			}
			$wrappedText .= $wrappedLine."\n" ;
		}
		return $wrappedText ;
	}
	
	/**
	 * found here, not sure of the author :
	 * http://devzone.zend.com/article/2525-Zend_Pdf-tutorial#comments-2535
	 */
	protected function widthForStringUsingFontSize($string, $font, $fontSize)
	{
		$drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
		$characters = array();
		for ($i = 0; $i < strlen($drawingString); $i++) {
			$characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
		}
		$glyphs = $font->glyphNumbersForCharacters($characters);
		$widths = $font->widthsForGlyphs($glyphs);
		$stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
		return $stringWidth;
	}
}

