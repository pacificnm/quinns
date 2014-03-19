<?php
class PumpTest_Form_Element_Owner extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Requested By:');
		$this->setRequired(true);
		$this->setAttrib('class', 'medium')
			->setAttrib('autocomplete', 'off');
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Requested By</b> is required!')));
	}
}