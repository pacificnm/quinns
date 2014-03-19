<?php
/**
 * MyFlix
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.pacificnm.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to pacificnm@gmail.com so we can send you a copy immediately.
 *
 * @category   Application
 * @package    Model
 * @copyright  Copyright (c) 2013 Pacific Network Management
 * @license    New BSD License
 * @version    $Id: Indexer.php 1.0  Jaimie Garner $
 */
class Application_Model_Indexer extends Zend_Search_Lucene_Document
{
	/**
	 * 
	 * @param unknown $document
	 */
    public function __construct($document)
    {
    	Zend_Search_Lucene::setDefaultSearchField('contents');
    	
        $this->addField(Zend_Search_Lucene_Field::Keyword('id', $document['id']));
        $this->addField(Zend_Search_Lucene_Field::UnIndexed('url', $document['url']));
        $this->addField(Zend_Search_Lucene_Field::UnIndexed('created',$document['created']));
        $this->addField(Zend_Search_Lucene_Field::UnIndexed('tagline',$document['tagline']));
        $this->addField(Zend_Search_Lucene_Field::UnIndexed('overview',$document['overview']));
        $this->addField(Zend_Search_Lucene_Field::Text('title', $document['title']));
    }
}