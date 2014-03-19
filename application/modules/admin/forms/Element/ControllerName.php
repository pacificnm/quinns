<?php
class Admin_Form_Element_ControllerName extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Controller Name:')
			->setRequired(true);
	}
}