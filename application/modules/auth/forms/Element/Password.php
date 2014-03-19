<?php
class Auth_Form_Element_Password extends Zend_Form_Element_Password
{
	public function init()
	{
		$this->setLabel('Password')
			->setRequired(true);
		
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
		
		$this->addValidator('NotEmpty', false, array('messages' =>
				array('isEmpty' => '<b>Password</b> is required!')));
	}
}