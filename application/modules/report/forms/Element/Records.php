<?php
class Report_Form_Element_Records extends Zend_Form_Element_Text
{
	public function init()
	{
		$this->setLabel('Number Of Records:')
			->setAttrib('size', '4');
	}
}