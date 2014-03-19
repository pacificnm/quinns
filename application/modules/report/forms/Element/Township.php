<?php
class Report_Form_Element_Township extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Township:')
			->setAttrib('size', '8');
	}
}