<?php
class Owner_Form_Element_Type extends Zend_Form_Element_Select
{
	public function init()
	{


		$this->setLabel(Person_Model_String::PERSON_TYPE)
		->setRequired(TRUE);


		$this->addMultiOption(Person_Model_String::PERSON_OWNER, Person_Model_String::PERSON_OWNER);
		$this->addMultiOption(Person_Model_String::PERSON_RENTER, Person_Model_String::PERSON_RENTER);
		$this->addMultiOption(Person_Model_String::PERSON_REALTOR, Person_Model_String::PERSON_REALTOR);

		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));

	}
}
