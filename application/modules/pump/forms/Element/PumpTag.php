<?php
class Pump_Form_Element_PumpTag extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Well Tag #:')
			->setRequired(false)
			->setAttrib('size', '20');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pump Tag</b> is required! If you do not know the <b>Pump Tag</b> enter Unknown')));
		
	}
}