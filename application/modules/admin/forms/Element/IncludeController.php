<?php
class Admin_Form_Element_IncludeController extends Zend_Form_Element_Checkbox
{
	public function init()
	{
		$this->setLabel('Include Default Controllers:');
	}
}