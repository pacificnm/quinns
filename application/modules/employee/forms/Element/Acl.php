<?php
class Employee_Form_Element_Acl extends Zend_Form_Element_Select
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Access:')
		->setAttrib('class', 'medium');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));


		$this->addMultiOption('admin', 'Admin')
		->addMultiOption('employee', 'Employee');
	}

}