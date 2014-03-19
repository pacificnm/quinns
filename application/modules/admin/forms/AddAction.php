<?php

class Admin_Form_AddAction extends Zend_Form
{

    public function init()
    {
    	$this->addElement(new Admin_Form_Element_ActionName('name'));
    	
    	$this->addElement(new Admin_Form_Element_ActionAcl('acl'));
    	
    	$this->addElement(new Admin_Form_Element_ActionAuth('auth'));
    	
        $this->addElement(new Admin_Form_Element_Submit('submit'));
    }


}

