<?php
class Owner_Form_Element_Name extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Name:')
			->setRequired(true)
			->setAttrib('class', 'medium')
			->setAttrib('autocomplete', 'off');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Name</b> is required!')));
	}
}