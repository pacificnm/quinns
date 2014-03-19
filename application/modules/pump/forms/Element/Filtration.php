<?php
class Pump_Form_Element_Filtration extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Filtration:')
			->setRequired(false)
			->setAttrib('class', 'medium');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Filtration</b> is required! If you do not know the <b>Filtration</b> enter Unknown')));
		
	}
}