<?php
class Report_Form_Element_SectionDivision extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Section Division:')
			->setAttrib('size', '8');
	}
}