<?php
class PumpTest_Form_Element_Seal extends Zend_Form_Element_Select
{

	public function init()
	{
		$this->setLabel('Seal:')
		->setRequired(true);

		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Seal</b> is required!.')));

		$this->addMultiOption('No','No')
		->addMultiOption('Yes', 'Yes');
	}
}