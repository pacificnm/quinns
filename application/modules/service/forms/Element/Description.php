<?php 
class Service_Form_Element_Description extends Zend_Form_Element_Textarea
{
	public function init()
	{
		$this->setLabel('Description of Service:')
			->setRequired(false)
			->setAttrib('rows', '8');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		//$this->addValidator('NotEmpty', false, array('messages' =>
		//		array('isEmpty' => '<b>Description of Service</b> is required!')));
	}
}