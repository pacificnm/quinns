<?php
class Pump_Form_Element_WellDepth extends Zend_Form_Element_Text
{
	public function init()
	{
		
		
		$this->setLabel('Well Depth:')
			->setRequired(false)
			->setAttrib('size', '4');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		
	}
}