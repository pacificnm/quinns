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
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Location_Model_Pdf extends Zend_Pdf
{

	public function location($location,$owner,$schedule,$pumps,$note,$pumpTests,$services)
	{
		$pdf = new Zend_Pdf();
		
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		$style = new Zend_Pdf_Style();
		$style->setFont($font, 11);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Location Report', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);
		
		// logo
		$image = Zend_Pdf_Image::imageWithPath(IMAGE_PATH .'/pdf-logo.jpg');
		$page->drawImage($image, 10, 738, 185, 796);
		
		$startLine = 790;
		
		// record id
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Record ID:', 195, $startLine, 'UTF-8');		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->id, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Street Address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Street Address:', 195, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->street, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText($location->city .', ' . $location->state .' ' . $location->zip, 292, 754, 'UTF-8');
		
		$startLine-=18;
		
		
		
		
		// owner name
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Name:', 195, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->name, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Scheduled Service
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Scheduled Date:', 20, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y",$schedule->service_due), 115, $startLine, 'UTF-8');
		
		// billing address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Address:', 195, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->street, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText($owner->city .', ' . $owner->state .' ' . $owner->zip, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Telephone
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Telephone:', 195, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->phone, 292, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// access
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Access:', 20, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->access, 65, $startLine, 'UTF-8');
		
		// Boom Truck
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Boom Truck:', 150, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->boom_truck == 1 ? 'Yes' : 'No', 220, $startLine, 'UTF-8');
		
		// dog
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Dog:', 240, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->dog == 1 ? 'Yes' : 'No', 267, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Directions
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Directions:', 20, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$lines = explode("\n",$this->getWrappedText($note->directions,$style,400)) ;
		foreach($lines as $line){
			$page->drawText($line, 79, $startLine);
			$startLine-=18;
		}
		
		
		
		// note
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Note:', 20, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$lines = explode("\n",$this->getWrappedText($note->note,$style,400)) ;
		foreach($lines as $line){
			$page->drawText($line, 79, $startLine);
			$startLine-=18;
		}
		
		
		
		// number of men
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('# Men:', 20, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($note->men, 79, $startLine, 'UTF-8');
		
		
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Explanation:', 100, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$lines = explode("\n",$this->getWrappedText($note->explanation,$style,400)) ;
		foreach($lines as $line){
			$page->drawText($line, 168, $startLine);
			$startLine-=18;
		}
		
		
		$startLine-=18;
		// pump information
		
		$pumpCount = count($pumps);
		$count = 1;
		foreach($pumps as $pump) {
			
			// Pump Number
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Number:  ' . $count, 20, $startLine, 'UTF-8');
			
			
			$startLine = $startLine - 18;
			
			// Pump Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump:', 20, $startLine, 'UTF-8');			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pump_model, 90, $startLine, 'UTF-8');
			
			// Pump Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pump_depth .' feet', 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			
			// pump type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pump_type, 90, $startLine, 'UTF-8');
	
			
			// well Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Well Depth:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->well_depth .' feet', 380, $startLine, 'UTF-8');
				
			$startLine = $startLine - 18;
			
			// pump_tag
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Tag:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pump_tag, 90, $startLine, 'UTF-8');
			
			// Tank Size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Size:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->size, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			// volts
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Volts:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->voltage, 90, $startLine, 'UTF-8');
			
			// Tank Type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Type:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->type, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			// Phase
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Phase:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->phase, 90, $startLine, 'UTF-8');
			
			// Tank Model
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Model:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->model, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			// wire
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Wire:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->wire, 90, $startLine, 'UTF-8');
			
			// Filtration
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Filtration:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->filtration, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			// pipe type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Type:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pipe, 90, $startLine, 'UTF-8');
			
			//static_level
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Static Level:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->static_level, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			
			// pipe size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Size:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->pipe_size, 90, $startLine, 'UTF-8');
			
			// use
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Water Use:', 292, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($pump->use, 380, $startLine, 'UTF-8');
			
			$startLine = $startLine - 18;
			$count++;
		}
		
		// add page to document
		$pdf->pages[] = $page;
	
			
		
		
		
		// Page 2
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Flow Tests', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);

		if(count($pumpTests) > 0) {
		
			foreach ($pumpTests as $pumpTest) {
				
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
				
			}
		} else {
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('No Pump Tests on record.', 20, 790, 'UTF-8');
		}
		
		$pdf->pages[] = $page;
		
		
		
		// Page 3
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Service Records', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);
		
		$startLine = 790;
		
		foreach($services as $service){
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Service Date:', 20, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText(date("M d, Y",$service->date) , 96, $startLine, 'UTF-8');
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Requested By:', 170, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($service->name , 250, $startLine, 'UTF-8');
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Employee:', 430, $startLine, 'UTF-8');
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText($service->employee , 488, $startLine, 'UTF-8');
			
			$startLine-=18;
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$lines = explode("\n",$this->getWrappedText($service->description,$style,550)) ;
			foreach($lines as $line){
				$page->drawText($line, 20, $startLine);
				$startLine-=18;
			}
			
			
		}
		
		
		$pdf->pages[] = $page;
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Well Pro';
		$pdf->properties['Title'] = 'Well Report For ';
		$pdf->properties['Subject'] = 'Well Report';
		
		
		
		$pdfData = $pdf->render();

		return $pdfData;
	}
	
	
	
	
	
	
	public function serviceReport()
	{
		$pdf = new Zend_Pdf();
		
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Location Data Report', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);
		
		// record id
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Record ID:', 150, 790, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->id, 210, 790, 'UTF-8');
		
		// Street Address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Street Address:', 150, 772, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->street, 238, 772, 'UTF-8');
		$page->drawText($location->city .', ' . $location->state .' ' . $location->zip, 238, 754, 'UTF-8');
		
		// service date
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service Date:', 20, 708, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y", time()), 115, 708, 'UTF-8');
		
		// Scheduled Service
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Scheduled Date:', 20, 690, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y",$schedule->service_due), 115, 690, 'UTF-8');
		
		
		// owner name
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Name:', 195, 708, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->name, 292, 708, 'UTF-8');
		
		// billing address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Address:', 195, 690, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->street, 292, 690, 'UTF-8');
		$page->drawText($owner->city .', ' . $owner->state .' ' . $owner->zip, 292, 672, 'UTF-8');
		
		// Telephone
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Telephone:', 195, 654, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->phone, 292, 654, 'UTF-8');
		
		// pump information
		$pumpCount = count($pumps);
		
		// Pump
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Pump:', 20, 626, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->pump_model == 'Unknown') {
			$page->drawText('_____________', 90, 626, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->pump_model, 90, 626, 'UTF-8');
		}
		
		
		
		// pump type
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Type:', 20, 608, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->pump_type == 'Unknown') {
			$page->drawText('_____________', 90, 608, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->pump_type, 90, 608, 'UTF-8');
		}
		
		
		// volts
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Volts:', 20, 590, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->voltage == 'Unknown'){
			$page->drawText('_____________', 90, 590, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->voltage, 90, 590, 'UTF-8');
		}
		
		
		// Phase
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Phase:', 20, 572, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->phase == 'Unknown'){
			$page->drawText('_____________', 90, 572, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->phase, 90, 572, 'UTF-8');
		}
		
		
		// wire
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Wire:', 20, 554, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->wire == 'Unknown') {
			$page->drawText('_____________', 90, 554, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->wire, 90, 554, 'UTF-8');
		}
		
		
		// pipe type
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Pipe Type:', 20, 536, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->pipe == 'Unknown') {
			$page->drawText('_____________', 90, 536, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->pipe, 90, 536, 'UTF-8');
		}
		
		// pipe size
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Pipe Size:', 20, 518, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		
		if($pumps[0]->pipe_size == 'Unknown') {
			$page->drawText('_____________', 90, 518, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->pipe_size, 90, 518, 'UTF-8');
		}
		
		
		
		// man Needed
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('# Men:', 20, 500, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('1', 90, 500, 'UTF-8');
		
		// Boom Truck
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Boom Truck:', 20, 482, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('No', 90, 482, 'UTF-8');
		
		
		// Pump Depth
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Pump Depth:', 292, 626, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if($pumps[0]->pump_depth == 'Unknown') {
			$page->drawText('_____________', 380, 626, 'UTF-8');
		} else {
			$page->drawText($pumps[0]->pump_depth .' feet', 380, 626, 'UTF-8');
		}
		
		
		// Tank Size
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Tank Size:', 292, 608, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('tank_size', 380, 608, 'UTF-8');
		
		// Tank Type
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Tank Type:', 292, 590, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('tank_type', 380, 590, 'UTF-8');
		
		
		// Tank Type
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Tank Model:', 292, 572, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('tank_model', 380, 572, 'UTF-8');
		
		
		// Filtration
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Filtration:', 292, 554, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('tank_model', 380, 554, 'UTF-8');
		
		// Access
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Access:', 292, 536, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('access', 380, 536, 'UTF-8');
		
		// service tech
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Technician:', 292, 518, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('access', 380, 518, 'UTF-8');
		
		// add page to document
		$pdf->pages[] = $page;
		
			
		if($pumpCount > 1) {
			// Page 2
			$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
				
			// set font
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				
			// set title
			$page->setFont($font, 14);
			$page->drawText('Second Pump', 250, 812, 'UTF-8');
				
			// draw line
			$page->setLineWidth(0.5);
			$page->drawLine(10, 806, 592, 806);
				
				
			// Pump
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump:', 20, 626, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->pump_model == 'Unknown') {
				$page->drawText('_____________', 90, 626, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->pump_model, 90, 626, 'UTF-8');
			}
				
				
				
			// pump type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Type:', 20, 608, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->pump_type == 'Unknown') {
				$page->drawText('_____________', 90, 608, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->pump_type, 90, 608, 'UTF-8');
			}
				
				
			// volts
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Volts:', 20, 590, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->voltage == 'Unknown'){
				$page->drawText('_____________', 90, 590, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->voltage, 90, 590, 'UTF-8');
			}
				
				
			// Phase
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Phase:', 20, 572, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->phase == 'Unknown'){
				$page->drawText('_____________', 90, 572, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->phase, 90, 572, 'UTF-8');
			}
				
				
			// wire
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Wire:', 20, 554, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->wire == 'Unknown') {
				$page->drawText('_____________', 90, 554, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->wire, 90, 554, 'UTF-8');
			}
				
				
			// pipe type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Type:', 20, 536, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->pipe == 'Unknown') {
				$page->drawText('_____________', 90, 536, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->pipe, 90, 536, 'UTF-8');
			}
				
			// pipe size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pipe Size:', 20, 518, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
				
			if($pumps[1]->pipe_size == 'Unknown') {
				$page->drawText('_____________', 90, 518, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->pipe_size, 90, 518, 'UTF-8');
			}
				
				
		
				
			// Pump Depth
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Pump Depth:', 292, 626, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			if($pumps[1]->pump_depth == 'Unknown') {
				$page->drawText('_____________', 380, 626, 'UTF-8');
			} else {
				$page->drawText($pumps[1]->pump_depth .' feet', 380, 626, 'UTF-8');
			}
				
				
			// Tank Size
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Size:', 292, 608, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('tank_size', 380, 608, 'UTF-8');
				
			// Tank Type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Type:', 292, 590, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('tank_type', 380, 590, 'UTF-8');
				
				
			// Tank Type
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Tank Model:', 292, 572, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('tank_model', 380, 572, 'UTF-8');
				
				
			// Filtration
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			$page->setFont($font, 11);
			$page->drawText('Filtration:', 292, 554, 'UTF-8');
				
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$page->setFont($font, 11);
			$page->drawText('tank_model', 380, 554, 'UTF-8');
				
			$startLine = 626;
				
			$pdf->pages[] = $page;
		}
		
		
		// Page 2
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Service Records', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);
		
		
		$pdf->pages[] = $page;
		
		
		
		// Page 3
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		
		// set font
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		// set title
		$page->setFont($font, 14);
		$page->drawText('Flow Test', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(0.5);
		$page->drawLine(10, 806, 592, 806);
		
		
		$pdf->pages[] = $page;
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Well Pro';
		$pdf->properties['Title'] = 'Well Report For ';
		$pdf->properties['Subject'] = 'Well Report';
		
		
		
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

