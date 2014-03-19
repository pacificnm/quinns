<?php
class Owner_Form_Element_Email extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Email:');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		// add validator for email address
	}
}