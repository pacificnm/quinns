<?php
class Pump_Form_Element_PumpDepth extends Zend_Form_Element_Text
{
	public function init()
	{
		
		
		$this->setLabel('Pump Depth:')
			->setRequired(false)
			->setAttrib('size', '4');
			
			$this->setDecorators(array(
					'ViewHelper',
					'Description',
					array('HtmlTag', array('tag' => 'div')),
					array('Label', array('tag' => 'div')),
			));
			
			$this->addValidator('NotEmpty', true, array('messages' =>
					array('isEmpty' => '<b>Pump Depth</b> is required! If you do not know the <b>Pump Depth</b> enter 0')))
			->addValidator('int', true, array('messages' => array('notInt' => '<b>Pump Depth</b> is not a  valid number!',)));
			
	}
}
