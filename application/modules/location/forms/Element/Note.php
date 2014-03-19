<?php
class Location_Form_Element_Note extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Note:')
			->setAttrib('rows', '6');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}