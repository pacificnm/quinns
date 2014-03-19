<?php
/**
*
* @author Jaimie
*
*/
class Schedule_Form_Element_EndDate extends ZendX_JQuery_Form_Element_DatePicker
{

	/**
	 * (non-PHPdoc)
	 * @see Zend_Form_Element::init()
	 */
	public function init()
	{
		$this->setLabel('End Date:')
		->setRequired(true);


	}
}