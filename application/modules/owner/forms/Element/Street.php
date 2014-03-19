<?php
class Owner_Form_Element_Street extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Street:')
		->setRequired(true)
		->setAttrib('class', 'medium');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Street</b> is required!')));

	}
}