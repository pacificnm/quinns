<?php
class Report_Form_Element_Sctn extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Section:')
			->setAttrib('size', '8');
	}
}