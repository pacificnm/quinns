<?php
class Service_Form_Element_FlowTest extends Zend_Form_Element_Select
{

	public function init()
	{
		$this->setLabel('Include Flow Test:');

		$this->addMultiOption('0', 'No')
		->addMultiOption('1', 'Yes');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}