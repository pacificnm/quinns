<?php
class Pump_Form_Element_Phase extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Phase:')
			->setRequired(false)
			->setAttrib('class', 'mini');
			
		$this->addMultiOption('Unknown', 'Unknown')
		    ->addMultiOption('1', '1')
			->addMultiOption('2','2')
			->addMultiOption('3','3')
			->addMultiOption('4','4');
	}
}
