<?php
class Admin_Form_Element_ActionName extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Action Name:')
			->setRequired(true);
	}
}