<?php
class Well_Form_Element_Search extends Zend_Form_Element_Text
{

    public function init()
	{
		$this->setLabel('Address:')
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