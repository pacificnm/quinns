<?php
class Application_Form extends Zend_Form
{
	public function init()
	{
		$this->addElement(new Application_Form_Element_Submit('submit'));	
	}
}