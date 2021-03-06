<?php
class Location_Form_Delete extends Zend_Form
{

	public function __construct()
	{
		// this is where i normally set up my decorators for the form and elements
		// additionally you can register prefix paths for custom validators, decorators, and elements

		parent::__construct();
		// parent::__construct must be called last because it calls $form->init()
		// and anything after it is not executed
	}

	public function highlightErrorElements()
	{

		foreach($this->getElements() as $element) {
			if($element->hasErrors()) {

				$glass  = $element->getAttrib('class');

				$element->setDecorators(array(
						'ViewHelper',
						'Description',
						array('HtmlTag', array('tag' => 'div')),
						array('Label', array('tag' => 'div', 'class' => 'error')),
				));
				$element->setAttrib('class', $glass . ' error');
			}
		}


		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}

	public function init()
	{
		 
		 
	}
	
	public function location()
	{
		$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
		 
		$element = new Application_Form_Element_Submit('submit');
		$element->setLabel('Delete Location');
		$this->addElement($element);
		 
		return $this;
	}
}