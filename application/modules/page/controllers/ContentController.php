<?php

class Page_ContentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * @todo create dbtable and pull meta info from db
     */
    public function indexAction()
    {
    	
    	
    	$page = $this->getParam('name');
    	
    	$this->render($page);
    }

    public function itServiceAction()
    {
    	
    }

}

