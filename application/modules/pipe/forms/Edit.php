<?php

class Pipe_Form_Edit extends Zend_Form
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
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Form::init()
	 */
    public function init()
    {
        $this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    }

	
    /**
     * Edit Pipe Form 
     * 
     * @param Pipe_Model_Pipe $pipe
     * @return Pipe_Form_Edit
     */
    public function pipe($pipe)
    {
    	$element = new Pipe_Form_Element_Value('value');
    	$element->setValue($pipe->value);
    	
    	
    	$element->addValidator('Db_NoRecordExists', false, array('table' => 'pipe', 'field' => 'value',
    			'exclude' => array('field' => 'id', 'value' => $pipe->id),
    			'messages' => array('recordFound' => 'There is already a record for <b><i>%value%</i></b>')
    	));
    	
    	
    	$this->addElement($element);
    	
    	return $this;
    }
}

