<?php
class Report_Form_Element_Status extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Status:');
		
		$this->addMultiOption('', 'All')
		->addMultiOption('success', 'Success')
		->addMultiOption('fail', 'fail');
	}
}