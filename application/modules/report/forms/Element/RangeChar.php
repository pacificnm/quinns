<?php
class Report_Form_Element_RangeChar extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Range Direction:');
		$this->addMultiOption('W', 'West')
			->addMultiOption('E', 'East');
	}
}