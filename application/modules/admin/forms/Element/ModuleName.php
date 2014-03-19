<?php
class Admin_Form_Element_ModuleName extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Module Name')
			->setRequired(true);
	}
}