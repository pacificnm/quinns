<?php
class Location_Form_Element_Access extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Access:');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}