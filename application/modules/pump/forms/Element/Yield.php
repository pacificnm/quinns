<?php
class Pump_Form_Element_Yield extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Yield:')
			->setRequired(false)
			->setAttrib('size', '6');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Yield</b> is required! If you do not know the <b>Yield</b> enter Unknown')));
		
			
	}
}