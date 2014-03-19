<?php
class Service_Form_Element_Status extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Status:');
		
		$this->addMultiOption('Open', 'Open')
			->addMultiOption('Closed', 'Closed');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}