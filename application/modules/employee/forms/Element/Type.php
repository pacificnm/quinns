<?php
class Employee_Form_Element_Type extends Zend_Form_Element_Select
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Type:')
		->setAttrib('class', 'medium');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));


		$this->addMultiOption('employee', 'Employee')
		->addMultiOption('client', 'Client')
		->addMultiOption('admin', 'Admin');
	}

}