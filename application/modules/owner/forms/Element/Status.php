<?php
class Owner_Form_Element_Status extends Zend_Form_Element_Select
{
	public function init()
	{


		$this->setLabel('Status')
		->setRequired(TRUE);


		$this->addMultiOption('1', 'Active');
		$this->addMultiOption('0', 'Not Active');
		$this->addMultiOption('2', 'Delete');
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

	}
}
