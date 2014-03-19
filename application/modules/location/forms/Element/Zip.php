<?php
class Location_Form_Element_Zip extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Zip Code:')
			->setRequired(true)
			->setAttrib('class', 'normal');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Zip Code</b> is required!')))
			->addValidator('int', true, array('messages' => array('notInt' => '<b>Zip Code</b> is not a  valid number!',)));;
		
		
	}
}