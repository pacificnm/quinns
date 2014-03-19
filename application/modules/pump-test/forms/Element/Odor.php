<?php
class PumpTest_Form_Element_Odor extends Zend_Form_Element_Text
{

	public function init()
	{
		$this->setLabel('Water Odor:')
		->setRequired(true)
		->setAttrib('class', 'normal');

		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Water Odor</b> is required! Enter <b><i>None</i></b> for default value.')));
	}
}