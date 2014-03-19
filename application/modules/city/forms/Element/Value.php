<?php
class City_Form_Element_Value extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('City:')
		->setRequired(true)
		->setAttrib('class', 'medium');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>City</b> is required!')));
		
		
	}
}