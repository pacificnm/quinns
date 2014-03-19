<?php
class Pump_Form_Element_PumpModel extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Pump Model:')
			->setRequired(false)
			->setAttrib('class', 'medium');
		
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pump Model</b> is required! If you do not know the <b>Pump Model</b> enter Unknown')));
	}
}