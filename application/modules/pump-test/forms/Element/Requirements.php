<?php
class PumpTest_Form_Element_Requirements extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Test Requirements:')
			->setRequired(true)
			->setAttrib('rows', 4);
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Test Requirements</b> is required!')));
	}
}