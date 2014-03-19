<?php
class Employee_Form_Element_HomePhone extends Zend_Form_Element_Text
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Home Phone:')
		->setAttrib('class', 'medium');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

		
	}

}
