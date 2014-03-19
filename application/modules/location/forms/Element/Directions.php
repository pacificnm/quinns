<?php
class Location_Form_Element_Directions extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Directions:')
			->setAttrib('rows', '6');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}