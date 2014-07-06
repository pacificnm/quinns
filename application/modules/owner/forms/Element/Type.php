<?php
class Owner_Form_Element_Type extends Zend_Form_Element_Select
{
	public function init()
	{


		$this->setLabel('Contact Type')
		->setRequired(TRUE);


		$this->addMultiOption('Owner', 'Owner');
		$this->addMultiOption('Renter', 'Renter');
		$this->addMultiOption('Realtor', 'Realtor');

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

	}
}
