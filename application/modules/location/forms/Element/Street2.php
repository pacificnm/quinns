<?php
class Location_Form_Element_Street2 extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Street 2:')
		->setAttrib('class', 'medium');
	}
}