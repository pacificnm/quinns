<?php
class Service_Form_Element_Pump extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Pump:');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		
	}
}