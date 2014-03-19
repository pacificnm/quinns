<?php
class Pump_Form_Element_Voltage extends Zend_Form_Element_Select
{
	public function init(){
		$this->setLabel('Voltage:')
			->setRequired(false);
		
		$this->addMultiOption('Unknown', 'Unknown')
			->addMultiOption('12 DC', '12 DC')
			->addMultiOption('24 DC', '24 DC')
			->addMultiOption('48 DC', '48 DC')
			->addMultiOption('110 AC', '110 AC')
			->addMultiOption('120 AC', '120 AC')
			->addMultiOption('220 AC', '220 AC')
			->addMultiOption('230 AC', '230 AC')
			->addMultiOption('240 AC', '240 AC')
			->addMultiOption('380 AC', '380 AC')
			->addMultiOption('440 AC', '440 AC');
		
	}
	
		
}
