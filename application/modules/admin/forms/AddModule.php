<?php

class Admin_Form_AddModule extends Zend_Form
{

    public function init()
    {
    	$this->addElement(new Admin_Form_Element_ModuleName('name'));
    	
    	$this->addElement(new Admin_Form_Element_IncludeController('include'));
    	
        $this->addElement(new Admin_Form_Element_Submit('submit'));
    }


}

