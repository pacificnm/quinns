<?php
/**
 * Quinns Well And Pump
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.i-support-services.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@i-support-services.com so we can send you a copy immediately.
 *
 * @category   Schedule
 * @package    IndexController
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Schedule_IndexController extends Zend_Controller_Action
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
    	$page 		= $this->getParam('page');
    	 
    	
    	
    	$serviceModel = new Schedule_Model_Schedule();
    	
    	$form = new Schedule_Form_Search();
    	
    	$startDate 	= $this->getParam('startDate');
    	$endDate 	= $this->getParam('endDate');
    	
    	if(empty($startDate) or empty($endDate)) {
    		$startDate 	= mktime(0, 0, 0, date("m"), 1, date("Y"));
    		$endDate 	= mktime(0, 0, 0, date("m") +1, 1, date("Y"));
    	}
    	
    	
    	if ($this->getRequest()->isPost()) {		
    		if ($form->isValid($this->getRequest()->getPost())) {
    			
    			$startDate = strtotime($this->getParam('postStartDate'));
    			$endDate = strtotime($this->getParam('postEndDate')) + (23 * 3600);
				
    			print_r($this->getRequest()->getParams());
    			
    			
    			$this->redirect('/schedule/index/index/page/'.$page.'/startDate/'.$startDate.'/endDate/'.$endDate);
    		}
    	}

    	
    	$services = $serviceModel->loadByDate($startDate, $endDate, $page);
    	
    	$this->view->startDate 	= $startDate;
    	$this->view->endDate 	= $endDate;
    	
    	$this->view->services = $services;
    	$this->view->form = $form;
    }


}

