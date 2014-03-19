<?php
class PumpTest_Form_Element_Date extends ZendX_JQuery_Form_Element_DatePicker
{
	public function init()
	{
		$this->setLabel('Test Date:')
		->setRequired(true);

		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Test Date</b> is required!')));

		// add validator for date
	}
}