<?php
class Service_Form_Element_Complaint extends  Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Complaint:')
		->setRequired(true)
		->setAttrib('rows', '8');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Complaint Field</b> is required!')));
	}
}