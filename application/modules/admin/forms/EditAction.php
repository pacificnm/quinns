<?php

class Admin_Form_EditAction extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }

    public function action($action)
    {
    	$element = new Admin_Form_Element_ActionName('name');
		$element->setValue($action->name);
		$this->addElement($element);
    	
		$element = new Admin_Form_Element_ActionAuth('auth');
		$element->setValue($action->auth);
		$this->addElement($element);
		
		$element = new Admin_Form_Element_ActionAcl('acl');
		$element->setValue($action->acl);
		$this->addElement($element);
		
		$element = new Admin_Form_Element_MetaTitle('meta_title');
		$element->setValue($action->meta_title);
		$this->addElement($element);
		
    	$this->addElement(new Admin_Form_Element_Submit('submit'));
    	
    	return $this;
    }

}

