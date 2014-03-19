<?php
class PumpTest_Form_Element_Level extends Zend_Form_Element_Text
{

	public function init()
	{
		$this->setLabel('Pumping Level:')
		->setRequired(true)
		->setAttrib('class', 'normal');

		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pumping Level</b> is required!.')));
		
		$this->addValidator('int', true, array('messages' =>
				array('notInt' => '<b>Pumping Level</b> is not a valid number!.'), ));
	}
}