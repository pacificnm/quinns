<?php
class Service_Form_Element_Owner extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Requested By:');
		$this->setRequired(true);
		$this->setAttrib('class', 'medium');
	}
}