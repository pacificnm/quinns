<?php
class Service_Form_Element_Directions extends Zend_Form_Element_Select
{
	
	public function init()
	{
		$this->setLabel('Include Driving Directions:');
		
		$this->addMultiOption('1', 'Yes')
			->addMultiOption('0', 'No');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}