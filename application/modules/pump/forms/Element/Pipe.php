<?php
class Pump_Form_Element_Pipe extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Pipe Type:')
			->setRequired(false)
			->setAttrib('size', '10');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Pipe Type</b> Field is required! If you do not know the <b>Pipe Type</b> enter Unknown')));
	}
}