<?php
class PumpTest_Form_Element_Depth extends Zend_Form_Element_Text
{
	
	public function init()
	{
		$this->setLabel('Well Depth:')
			->setRequired(true)
			->setAttrib('class', 'normal');
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Well Depth</b> is required! If you do not know the depth enter 0.')));
		
		$this->addValidator('int', true, array('messages' =>
				array('notInt' => '<b>Well Depth:</b> is not a valid number!.'), ));
	}
}