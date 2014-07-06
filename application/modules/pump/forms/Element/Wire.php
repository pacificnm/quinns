<?php
class Pump_Form_Element_Wire extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Wire:')
			->setRequired(false)
			->setAttrib('size', '10');
		      
		
	}
}
