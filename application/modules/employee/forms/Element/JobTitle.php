<?php
class Employee_Form_Element_JobTitle extends Zend_Form_Element_Text
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Job Title:')
		->setAttrib('class', 'large');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

		
	}

}