<?php
class Owner_Form_Element_State extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('State:')
		->setRequired(true)
		->setAttrib('class', 'mini');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>State</b> is required!')));
			
		// add validator for sting length
		$this->addValidator('StringLength', true, array(2, 2));

		// add validator for alpha only
	}
}