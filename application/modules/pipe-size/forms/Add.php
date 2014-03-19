<?php

class PipeSize_Form_Add extends Zend_Form
{

	/**
	 *
	 */
	public function __construct()
	{
		// this is where i normally set up my decorators for the form and elements
		// additionally you can register prefix paths for custom validators, decorators, and elements
	
		parent::__construct();
		// parent::__construct must be called last because it calls $form->init()
		// and anything after it is not executed
	}
	
	/**
	 *
	 */
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
        /* Form Elements & Other Definitions Here ... */
    }
    
    public function pipeSize()
    {
    	$element = new PipeSize_Form_Element_Value('value');
    	$element->addValidator('Db_NoRecordExists', false, array('table' => 'pipe_size', 'field' => 'value',
    			'messages' => array('recordFound' => 'There is already a record for <b><i>%value%</i></b>')
    	));
    	 
    	$this->addElement($element);
    	 
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }


}

