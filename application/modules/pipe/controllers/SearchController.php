<?php
/**
 * Pipe Controller class
 *
 * @author ISS Jaimie Garner
 * @copyright 2013
 * @package Pipe
 * @category Controller
 * @version 1.0
 * @uses Zend_Controller_Action
 */


class Pipe_SearchController extends Zend_Controller_Action
{

    /**
     * Init
     */
    public function init()
    {
    }

    /**
     * indexAction
     */
    public function indexAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	 
    	$keyword = $this->getParam('search');
    	$pipeModel = new Pipe_Model_Pipe();
    	$results = $pipeModel->loadByKeyword($keyword);
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }


}

