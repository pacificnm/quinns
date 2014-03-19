<?php
/**
*
* @author Jaimie
*
*/
class Report_Form_Element_StartDate extends ZendX_JQuery_Form_Element_DatePicker
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('Start Date:');


	}
}