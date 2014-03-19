<?php
class PumpTest_Form_Element_PopOffValve extends Zend_Form_Element_Select
{

	public function init()
	{
		$this->setLabel('Pop Off Valve:')
		->setRequired(true);

		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pop Off Valve</b> is required!.')));

		$this->addMultiOption('No','No')
		->addMultiOption('Yes', 'Yes');
	}
}