<?php
class PumpTest_Form_Element_Diameter extends Zend_Form_Element_Text
{

	public function init()
	{
		$this->setLabel('Case Diameter:')
		->setRequired(true)
		->setAttrib('class', 'normal');
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Case Diameter</b> is required! If you do not know the Case Diameter enter 0.')));
		
		$this->addValidator('int', true, array('messages' =>
				array('notInt' => '<b>Case Diameter</b> is not a valid number!.'), ));
	}
}