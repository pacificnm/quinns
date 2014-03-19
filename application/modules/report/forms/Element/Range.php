<?php
class Report_Form_Element_Range extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Range:')
			->setAttrib('size', '8');
		
		
	}
}