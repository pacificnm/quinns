<?php 
class Employee_Form_Element_FirstName extends Zend_Form_Element_Text
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(true)
		->setLabel('First Name:')
			->setAttrib('class', 'large');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>First Name</b> is required!')));
	}

}