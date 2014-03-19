<?php
class Employee_Form_Element_Status extends Zend_Form_Element_Select
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Status:')
		->setAttrib('class', 'large');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));


		$this->addMultiOption('1', 'Active')
			->addMultiOption('0', 'Not Active');
	}

}