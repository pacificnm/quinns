<?php
class Admin_Form_Element_ActionAuth extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Require Authorization:');
		
		$this->addMultiOption('1', 'Yes');
		$this->addMultiOption('0', 'No');
	}
}