<?php
class Application_Form_Element_Delete extends Zend_Form_Element_Submit
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('Delete');
	}
}