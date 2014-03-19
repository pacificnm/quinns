<?php
class Location_Form_Element_Township extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Township:')
			->setAttrib('class', 'normal')
			->setAttrib('size', 6);
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}