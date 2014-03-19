<?php
class PumpTest_Form_Element_Remarks extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Test Remarks:')
		->setAttrib('rows', 4);

	}
}