<?php
class PumpTest_Form_Element_Flow extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Flow:')
			->setRequired(true)
			->setAttrib('class', 'small');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
}