<?php
class Well_SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function indexAction()
    {
        $WellFormSearch = new Well_Form_Search();
        $WellModelWell = new Well_Model_Well();
        $form = $WellFormSearch->search();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                
                $search = $this->getParam('search');
                
                $results = $WellModelWell->search($search, 'Address');
                
                $this->view->results = $results;
                
            } else {
    			$form->highlightErrorElements();
    		}
        } 
        
        $this->view->form = $form;
    }
    
    public function importAction()
    {
        $recordId = $this->getParam('record_id');
        if($record < 1) {
            throw new Zend_Exception('missing record_id');
        }
        
        // check if we already have record.
    }
}