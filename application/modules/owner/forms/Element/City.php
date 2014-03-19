<?php
class Owner_Form_Element_City extends Zend_Form_Element_Text
{
	public function init()
	{

		$this->setLabel('City:')
		->setRequired(true);

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