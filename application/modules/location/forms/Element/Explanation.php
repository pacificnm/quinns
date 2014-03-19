<?php
class Location_Form_Element_Explanation extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Explanation:')
			->setAttrib('rows', '6');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
	}
}