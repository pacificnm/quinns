<?php
class Location_Form_Element_Men extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Men:');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}