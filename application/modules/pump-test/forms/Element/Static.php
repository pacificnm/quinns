<?php
class PumpTest_Form_Element_Static extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Static Level:')
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