<?php
class Pump_Form_Element_StaticLevel extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Static Level:')
			->setRequired(false)
			->setAttrib('size', 4);
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Static Level</b> is required! If you do not know the <b>Static Level</b> enter Unknown')));
		
	}
}