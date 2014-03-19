<?php
class Location_Form_Element_Sctn extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Section:')
		->setAttrib('class', 'normal')
		->setAttrib('size', '4');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}