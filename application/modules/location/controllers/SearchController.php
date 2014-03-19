<?php

class Location_SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {	
    	
        $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$keyword = $this->getParam('keyword');
    	$type = $this->getParam('type');
    	
    	$serchModel = new Location_Model_LocationSearch();
    	$results = $serchModel->loadByKeyword($keyword,$type);
    	
    	if(empty($results)) {
    		$results = array('noResult' => 1);
    	}
    	
    	echo Zend_Json::encode($results);
    	
    	exit();
    }
    
    public function searchAction()
    {
    	
    	
    	$street = $this->getParam('address');
    	
    	$locationModel = new Location_Model_Location();
    	$location = $locationModel->loadByAddress($street);
    	if(empty($location)) {
    		//$this->redirect('/location/add/index/street/' .urlencode($street) );
    	}
    }


    public function newSearchAction()
    {
    	$text = $this->getParam('address');
    	
    	$indexPath = APPLICATION_PATH . '/search';
    	
    	Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());
    	
    	Zend_Search_Lucene::setResultSetLimit(10);
    	
    	$index = Zend_Search_Lucene::open($indexPath);
    	
    	$hits = $index->find($text);
    	
    	$this->view->hits = $hits;
    	
    	
    	//Zend_Debug::dump($hits);
    }
}

