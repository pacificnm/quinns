<?php
/**
 * 
 * @author Jaimie
 *
 */
class Owner_Form_Add extends Zend_Form
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
        /* Form Elements & Other Definitions Here ... */
    }

    public function owner($name,$street,$city,$state,$zip)
    {
    	$element = new Owner_Form_Element_Name('name');
    	$element->setValue($name);
    	$this->addElement($element);
    
    	$this->addElement(new Owner_Form_Element_Phone('phone'));
    	
    	$this->addElement(new Owner_Form_Element_Email('email'));
    	 
    	$element = new Owner_Form_Element_Street('street');
    	$element->setValue($street);
    	$this->addElement($element);
    	
    	$this->addElement(new Owner_Form_Element_Street2('street2'));
    	 
    	$element = new Owner_Form_Element_City('city');
    	$element->setValue($city);
    	$this->addElement($element);
    	 
    	$element = new Owner_Form_Element_State('state');
    	$element->setValue($state);
    	$this->addElement($element);
    	 
    	$element = new Owner_Form_Element_Zip('zip');
    	$element->setValue($zip);
    	$this->addElement($element);
    	 
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }

    /**
     * 
     */
    public function location()
    {
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }
}

