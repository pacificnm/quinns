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
 * @category   PumpTest
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 * 
 * @uses Zend_Pdf
 */
class PumpTest_Model_Pdf extends Zend_Pdf
{

	/**
	 * Creates pump test PDF 
	 * 
	 * @param Object $pumpTest
	 * @param Object $flowData
	 * @param int $location
	 * @param object $owner
	 */
	public function pumpTest($pumpTest,$flowData,$location,$owner)
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
		$page->drawText('Well Flow Test', 250, 812, 'UTF-8');
		
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
		$page->drawText('Test ID:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($pumpTest->id, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// Street Address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Street Address:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($location->street, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText($location->city .', ' . $location->state .' ' . $location->zip, 320, 754, 'UTF-8');
		
		$startLine-=18;
		$startLine-=18;
		
		// Test date
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Test Date:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y",$pumpTest->date), 95, $startLine, 'UTF-8');
		
		
		// owner name
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Name:', 230, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->name, 320, $startLine, 'UTF-8');
		
		
		
		
		$startLine-=18;
		
		// tech
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Service Tech:', 10, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if(!empty($pumpTest->first_name)) {
			$page->drawText($pumpTest->first_name . ' ' . $pumpTest->last_name , 95, $startLine, 'UTF-8');
		} else {
			$page->drawText('Unknown', 95, $startLine, 'UTF-8');
		}
		
		// billing address
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Billing Address:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->street, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText($owner->city .', ' . $owner->state .' ' . $owner->zip, 320, $startLine, 'UTF-8');
		
		
		$startLine-=18;
		
		// Telephone
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Telephone:', 230, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($owner->phone, 320, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// requirements
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Test Requirements:', 10, $startLine, 'UTF-8');
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
		$page->drawText('Remarks:', 10, $startLine, 'UTF-8');
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
		$page->drawText('Equipment Used:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($pumpTest->equipment , 116, $startLine, 'UTF-8');
			
		// source
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Source:', 390, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if(empty($pumpTest->source)) {
			$page->drawText('Unknown' , 435, $startLine, 'UTF-8');
		} else {
			$page->drawText($pumpTest->source , 435, $startLine, 'UTF-8');
		}	
		$startLine-=18;
			
		// well depth
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Well Depth:', 10, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		if(empty($pumpTest->depth)) {
			$page->drawText('Unknown' , 82, $startLine, 'UTF-8');
		} else {
			$page->drawText($pumpTest->depth , 82, $startLine, 'UTF-8');
		}	
		
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
		$page->drawText('Water Color:', 10, $startLine, 'UTF-8');
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
		$page->drawText('Flow Data', 10, $startLine, 'UTF-8');
			
			
		$startLine-=18;
			
		$page->drawText('Time', 20, $startLine, 'UTF-8');
		$page->drawText('Flow', 120, $startLine, 'UTF-8');
		$page->drawText('Level', 190, $startLine, 'UTF-8');
		$page->drawText('Meter', 260, $startLine, 'UTF-8');
			
		$page->setLineWidth(0.5);
		$page->drawLine(10, ($startLine -2), 592, ($startLine -2));
			
		$startLine-=18;
		
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
		
		//$page->drawText('Flow Average', 120, $startLine, 'UTF-8');
		
		//$page->drawText('Average Level', 220, $startLine, 'UTF-8');
		
		$page->drawText('Total Gallons', 320, $startLine, 'UTF-8');
			
		$startLine-=18;
		
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText('4 Hours', 10, $startLine, 'UTF-8');
		
		//$page->drawText(number_format($flowAverage / $count, 2, '.', '') . ' GPM', 120, $startLine, 'UTF-8');
		//$page->drawText(number_format($averageLevel / $count, 2, '.', '') .' Feet', 220, $startLine, 'UTF-8');
		$page->drawText( number_format($meter, 2, '.', '') . ' Gallons', 320, $startLine, 'UTF-8');

		$startLine-=18;
		
		$startLine-=18;
		
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 9);
		
		$page->drawText('GPM = Gallons per minute being pumped out of well.', 10, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText('Level = The distance from the top of the well to the water level in the well.', 10, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		$page->drawText('Meter = Total gallons of water pumped from well.', 10, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		
		$page->drawText('Page  '. $pageNum . ' ' . date("M d, Y", time()), 265, 18);
		
		// add page
		$pdf->pages[] = $page;
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Quinns Well Pro';
		$pdf->properties['Title'] = 'Pump Test Report For  Created on ' . date("M d, Y", time());
		$pdf->properties['Subject'] = 'Pump Test Report For  Created on ' . date("M d, Y", time());
		
		
		
		$pdfData = $pdf->render();
		
		return $pdfData;
	}
	
	/**
	 * Creates text boxes
	 * 
	 * @param string $string
	 * @param Zend_Pdf_Style $style
	 * @param int $max_width
	 * @todo Move to a Application Class
	 */
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
	 * Gets real string width
	 * @param string $string
	 * @param Object $font
	 * @param string $fontSize
	 * @return number
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

