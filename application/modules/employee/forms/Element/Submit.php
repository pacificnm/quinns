<?php 
/**
 * Client Form Element Submit used to create custom submit element
 *
 * @author Jaimie Garner
 * @copyright 2013 Jaimie Garner
 *
 * @package Client
 * @category Element
 * @version 1.0
 *
 */
class Employee_Form_Element_Submit extends Zend_Form_Element_Submit
{
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('Save');
	}
}