<?php
class Location_Form_Element_TownshipChar extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Township Character:');
		$this->addMultiOption('S','S')
			->addMultiOption('N','N');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}