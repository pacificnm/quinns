<?php
class Owner_Form_Element_Phone extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Phone:')
			->setRequired(true);
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Phone</b> is required!')));
	}
}