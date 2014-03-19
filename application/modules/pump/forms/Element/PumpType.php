<?php
class Pump_Form_Element_PumpType extends Zend_Form_Element_Text
{
	public function init()
	{
		
		$this->setLabel('Pump Type:')
			->setRequired(false)
			->setAttrib('size', '20');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pump Type</b> is required! If you do not know the <b>Pump Type</b> enter Unknown')));
	}
}
