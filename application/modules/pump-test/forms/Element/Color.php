<?php
class PumpTest_Form_Element_Color extends Zend_Form_Element_Text
{

	public function init()
	{
		$this->setLabel('Water Color:')
		->setRequired(true)
		->setAttrib('class', 'normal');

		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Water Color</b> is required! Enter <b><i>Clear</i></b> for default value.')));
	}
}