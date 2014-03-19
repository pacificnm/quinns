<?php
class Pump_Form_Element_TankSize extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Tank Size:')
			->setRequired(false)
			->setAttrib('class', 'mini');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Tank Size</b> is required! If you do not know the <b>Tank Size</b> enter 0')));
	}
}