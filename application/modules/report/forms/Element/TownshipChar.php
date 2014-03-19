<?php
class Report_Form_Element_TownshipChar extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Direction:');
		$this->addMultiOption('S', 'South')
			->addMultiOption('N', 'North');
	}
}