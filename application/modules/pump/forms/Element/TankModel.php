<?php
class Pump_Form_Element_TankModel extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Tank Model:')
			->setRequired(false)
			->setAttrib('class', 'medium');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Tank Model</b> is required! If you do not know the <b>Tank Model</b> enter Unknown')));
	}
}