<?php
class PumpTest_Form_Element_Equipment extends Zend_Form_Element_Text
{

	public function init()
	{
		$this->setLabel('Equipment Used:')
		->setRequired(true)
		->setAttrib('class', 'medium');

		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Equipment Used</b> is required!.')));
	}
}