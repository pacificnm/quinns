<?php
class Service_Form_Element_Date extends ZendX_JQuery_Form_Element_DatePicker
{
	public function init()
	{
		$this->setLabel('Service Date:')
			->setRequired(true);
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Service Date</b> is required!')));
		
		// add validator for date
	}
}