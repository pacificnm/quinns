<?php

class Admin_Form_AddController extends Zend_Form
{

    public function init()
    {
    	$this->addElement(new Admin_Form_Element_ControllerName('name'));
    	
    	$this->addElement(new Admin_Form_Element_IncludeAction('include'));
    	
        $this->addElement(new Admin_Form_Element_Submit('submit'));
    }


}

