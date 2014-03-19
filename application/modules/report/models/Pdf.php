<?php
class Report_Model_Pdf extends Zend_Pdf
{
	public function selectedSite($selectedSite,$selectedSiteData)
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
		$page->drawText('Selected Sites Report', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(1);
		$page->drawLine(10, 806, 592, 806);
		
		
		// logo
		$image = Zend_Pdf_Image::imageWithPath(IMAGE_PATH .'/pdf-logo.jpg');
		$page->drawImage($image, 10, 738, 185, 796);
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Search Term:', 220, 738, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($selectedSite->search, 296, 738, 'UTF-8');
		
		
		$startLine = 712;
		
		// prepaired for
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Prepaired For:', 20, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($selectedSite->name, 100, $startLine, 'UTF-8');
		
		// date
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Date:', 220, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("m d, Y",$selectedSite->date), 256, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Prepaired By:', 350, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($selectedSite->first_name, 426, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// address
		$page->drawText($selectedSite->street, 20, $startLine, 'UTF-8');
		$startLine-=18;
		$page->drawText($selectedSite->city . ' ' .$selectedSite->state.', ' .$selectedSite->zip  , 20, $startLine, 'UTF-8');
		
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Phone:', 220, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(preg_replace('/\s+?(\S+)?$/', '', substr( $selectedSite->phone, 0, 40)) , 260, $startLine, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Email:', 350, $startLine, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText($selectedSite->email, 386, $startLine, 'UTF-8');
		
		$startLine-=18;
		
		// draw line
		$page->setLineWidth(1);
		$page->drawLine(10, $startLine, 592, $startLine);
			
		$startLine-=18;
		
		// headings		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 9);
		
		
		$page->drawText('No.', 20, $startLine, 'UTF-8');
		$page->drawText('PLSS', 40, $startLine, 'UTF-8');
		$page->drawText('Address', 125, $startLine, 'UTF-8');
		$page->drawText('Well Tag', 290, $startLine, 'UTF-8');
		$page->drawText('Depth', 350, $startLine, 'UTF-8');
		$page->drawText('Level', 380, $startLine, 'UTF-8');
		$page->drawText('Yield', 410, $startLine, 'UTF-8');
		$page->drawText('Filed', 440, $startLine, 'UTF-8');
		//$page->drawText('Driller', 500, $startLine, 'UTF-8');
		
		$startLine-=6;
		
		$page->setLineWidth(1);
		$page->drawLine(10, $startLine, 592, $startLine);
		
		$startLine-=18;
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 8);
		
		$count = 1;
		foreach($selectedSiteData as $data) {
			
			$page->drawText($count, 20, $startLine, 'UTF-8');
			$page->drawText((int)$data->township.' '.$data->township_char.' '.(int)$data->range.' '.$data->range_char.' '.$data->sctn.' '.$data->qtr160.$data->qtr40, 40, $startLine, 'UTF-8');
			$page->drawText($data->street_of_well, 125, $startLine, 'UTF-8');
			$page->drawText($data->well_tag_nbr, 300, $startLine, 'UTF-8');
			$page->drawText($data->completed_depth, 350, $startLine, 'UTF-8');
			$page->drawText($data->post_static_water_level, 380, $startLine, 'UTF-8');
			$page->drawText($data->max_yield, 410, $startLine, 'UTF-8');
			$page->drawText(date("M D, Y",$data->received_date), 440, $startLine, 'UTF-8');
			//$page->drawText( preg_replace('/\s+?(\S+)?$/', '', substr( $data->bonded_name_company, 0, 40)), 500, $startLine, 'UTF-8');
			$count++;
			$startLine-=20;
			
			if($startLine <= 20) {
				$pdf->pages[] = $page;
				$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
			
				// set font
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 8);
			
			
			
				$startLine = 806;
			
			}
		}
		
		
		// footer
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 9);
		$page->drawText('Page  '. $pageNum . ' ' . date("M d, Y", time()), 265, 18);
		$pdf->pages[] = $page;
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Quinns Well Pro';
		$pdf->properties['Title'] = 'Selected Sites Report';
		$pdf->properties['Subject'] = 'Selected Site Report Created on ' . date("M d, Y", time());
		
		
		
		$pdfData = $pdf->render();
		
		return $pdfData;
	}
	
	/**
	 * 
	 */
	public function serviceDue($results, $startDate, $endDate)
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
		$page->drawText('Service Due Report', 250, 812, 'UTF-8');
		
		// draw line
		$page->setLineWidth(1);
		$page->drawLine(10, 806, 592, 806);
		
		
		// logo
		$image = Zend_Pdf_Image::imageWithPath(IMAGE_PATH .'/pdf-logo.jpg');
		$page->drawImage($image, 10, 738, 185, 796);
		
		
		
		// set start date and end date
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Report Start Date:', 200, 788, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y", $startDate), 300, 788, 'UTF-8');
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		$page->drawText('Report End Date:', 200, 770, 'UTF-8');
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 11);
		$page->drawText(date("M d, Y", $endDate), 300, 770, 'UTF-8');
		
		$startLine = 712;
		
		// set headers 
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
		$page->setFont($font, 11);
		
		// date
		$page->drawText('Date:', 20, $startLine, 'UTF-8');
		$page->drawText('Location:', 100, $startLine, 'UTF-8');
		$page->drawText('Owner:', 270, $startLine, 'UTF-8');
		$page->drawText('Phone:', 400, $startLine, 'UTF-8');
		
		
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$page->setFont($font, 10);
		foreach($results as $result) {
			$startLine-=18;
			
			
			$page->drawText(date("M d, Y", $result->service_due), 20, $startLine, 'UTF-8');
			$page->drawText($result->street, 100, $startLine, 'UTF-8');
			$page->drawText(preg_replace('/\s+?(\S+)?$/', '', substr( $result->name, 0, 60)), 270, $startLine, 'UTF-8');
			$page->drawText(preg_replace('/\s+?(\S+)?$/', '', substr( $result->phone, 0, 60)), 400, $startLine, 'UTF-8');
			// start new page and reset counter
			if($startLine <= 18) {
				$pdf->pages[] = $page;
				$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
				
				// set font
				$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
				$page->setFont($font, 10);
				
				
				
				$startLine = 806;
				
			}
		}
		
		
		// set Document properties
		$pdf->properties['Author'] = 'Quinns Well Pro';
		$pdf->properties['Title'] = 'Selected Sites Report';
		$pdf->properties['Subject'] = 'Service Due';
		
		$pdf->pages[] = $page;
		
		$pdfData = $pdf->render();
		
		return $pdfData;
	}
}