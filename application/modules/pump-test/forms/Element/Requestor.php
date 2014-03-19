<?php
class PumpTest_Form_Element_Requestor extends Zend_Form_Element_Hidden
{
	public function init()
	{
		$this->setRequired(true);
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Requested By</b> is required!')));
	}
}