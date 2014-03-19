<?php
class Location_Form_Element_BoomTruck extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Boom Truck:');
		
		$this->addMultiOption('1','Yes');
		$this->addMultiOption('0','No');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}