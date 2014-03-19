<?php
class PipeSize_Form_Element_Value extends Zend_Form_Element_Text
{
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('Pipe Size:')
		->setRequired(true)
		->setAttrib('class', 'medium');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Pipe Size</b> is required!')));
	
	}
}