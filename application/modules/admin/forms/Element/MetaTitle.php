<?php
class Admin_Form_Element_MetaTitle extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Action Title:')
		->setRequired(true);
	}
}