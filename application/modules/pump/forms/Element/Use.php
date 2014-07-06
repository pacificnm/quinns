<?php
class Pump_Form_Element_Use extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Use:');
		
		
		$this->addMultiOption('Unknown', 'Unknown')
		    ->addMultiOption('Domestic','Domestic')
			->addMultiOption('Irrigation', 'Irrigation')
			->addMultiOption('Community', 'Community')
			->addMultiOption('Livestock', 'Livestock')
			->addMultiOption('Industrial', 'Industrial')
			->addMultiOption('Injection', 'Injection')
			->addMultiOption('Thermal', 'Thermal')
			->addMultiOption('Dewatering', 'Dewatering')
			->addMultiOption('Piezometer', 'Piezometer')
			->addMultiOption('Other', 'Other');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}