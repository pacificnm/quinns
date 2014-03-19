<?php
/**
 * Admin IndexController admin functions
 *
 * @author Jaimie
 * @copyright 2013 Jaimie Garner
 *
 * @package Admin
 * @category Controller
 * @version 1.0
 *
 * @uses Zend_Controller_Action
 */
class Admin_SearchController extends Zend_Controller_Action
{



	/**
	 *
	 */
	public function indexAction()
	{
		 
	}

	public function scanAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$indexPath = APPLICATION_PATH . '/search';
		
		Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());
		
		$index = Zend_Search_Lucene::create($indexPath);
		
		$LocationModelLocation = new Location_Model_Location();
		$OwnerModelOwnerLocation = new Owner_Model_OwnerLocation();
		
		$locations = $LocationModelLocation->loadAll();
		
		echo '<html><head><style type="text/css">body {font-family:Courier;color: #CCCCCC;background: #000000;border: 3px double #CCCCCC;padding: 10px;}</style> </head><body>';
		
		/**
		 	$document['id'] = $location->street . ' ' . $location->city . ' ' . $location->state;
			$document['url'] = '/location/view/index/id/' . $location->id;
			$document['created'] = time();
			$document['tagline'] = 'Location';
			$document['title'] = $location->street . ' ' . $location->city . ' ' . $location->state;
			$document['overview'] = $location->street . ' ' . $location->city . ' ' . $location->state  . ' ' . $location->lat . ' ' . $location->lng;
			$index->addDocument(new Application_Model_Indexer($document));
		 */
		
		
		// locations
		foreach($locations as $location) {
			@ob_end_clean();
			ob_start();
			echo 'indexing Street ' . $location->street .'<br>';
			$doc = new Zend_Search_Lucene_Document();			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', $location->id));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('url', '/location/view/index/id/' . $location->id));
			$doc->addField(Zend_Search_Lucene_Field::Keyword('title', $location->street . ' ' . $location->city . ' ' . $location->state));
			$doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $location->street . ' ' . $location->city . ' ' . $location->state));
			$index->addDocument($doc);
			
			echo 'Done working with location ' . $location->street . '<br>';
			@ob_end_flush ();
			@flush ();
		}
		
		$index->commit();
		
		/**
		echo 'Done with locations now working on owners <br>';
		
		$owners = $OwnerModelOwnerLocation->loadAll();
		foreach($owners as $owner) {
			@ob_end_clean();
			ob_start();
			echo 'indexing Owner ' . $owner->name .'<br>';
			$document['id'] = $owner->name;
			$document['url'] = '/location/view/index/id/' . $owner->location;
			$document['created'] = time();
			$document['tagline'] = 'Owner';
			$document['title'] = $owner->name;
			$document['overview'] = $owner->name . ' ' . $owner->street . ' ' . $owner->city . ' ' . $owner->state ;
			$index->addDocument(new Application_Model_Indexer($document));
				
			echo 'Done working with Owner ' . $owner->name . '<br>';
			@ob_end_flush ();
			@flush ();
		}
		*/
				
	}

}

