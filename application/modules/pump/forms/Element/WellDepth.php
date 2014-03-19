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
		
		$this->addValidator('NotEmpty', true, array('messages' =>
				array('isEmpty' => '<b>Well Depth</b> is required! If you do not know the <b>Well Depth</b> enter 0')))
				->addValidator('int', true, array('messages' => array('notInt' => '<b>Well Depth</b> is not a  valid number!',)));
			
	}
}