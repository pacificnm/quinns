<?php
class PumpTest_Form_Element_Source extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Source:')
			->setRequired(true)
			->setAttrib('class', 'normal');
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Sourceh</b> is required! If you do not know the Source enter Unknown.')));
	}
}