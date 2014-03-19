<?php
class PumpTest_Form_Element_Vent extends Zend_Form_Element_Select
{

	public function init()
	{
		$this->setLabel('Vent:')
		->setRequired(true);

		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pumping Level</b> is required!.')));

		$this->addMultiOption('No','No')
			->addMultiOption('Yes', 'Yes');
	}
}