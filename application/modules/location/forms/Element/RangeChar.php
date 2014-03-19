<?php
class Location_Form_Element_RangeChar extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Range Character:');
		$this->addMultiOption('E','E')
		->addMultiOption('W','W');
	}
}