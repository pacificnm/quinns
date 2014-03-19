<?php
class Employee_Form_Element_Im extends Zend_Form_Element_Text
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{

		$this->setRequired(false)
		->setLabel('Instant Messenger:')
		->setAttrib('class', 'large');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));


	}

}