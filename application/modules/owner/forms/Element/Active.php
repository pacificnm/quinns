<?php
class Owner_Form_Element_Active extends Zend_Form_Element_Submit
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('Set Active');
	}
}