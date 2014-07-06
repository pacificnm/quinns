<?php
class Location_JsonController extends Zend_Controller_Action
{

	public function init()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	
	public function browseAction()
	{
		
		//Zend_Debug::dump($this->getParam('order'));
		//die;
		
		$order = $this->getParam('order');
		$column = (int) $order[0]['column'];
		$dir = $order[0]['dir'];
		
		$sortColumnArray = array('street', 'city', 'state', 'zip' );
		$sortColumn = $sortColumnArray[$column];
		
		//echo $sortColumn;
		
		
		$Lml = new Location_Model_Location();
		
		$iDisplayStart = (int) $this->getParam('start', 0);
		$iDisplayLength = (int) $this->getParam('length', 10);
		
		$search = $this->getParam('search', 'street');
		
		
		$page = ($iDisplayStart / $iDisplayLength) + 1;
			
		$datas = $Lml->browse($page, $iDisplayLength, $search['value'], $sortColumn, $dir);
		
		
		
		$rows = array();
		foreach($datas as $data) {
			$row = array();
			$row[] = '<a href="/location/view/index/id/'.$data->id.'">'.$data->street.'</a>';
			$row[] = '<a href="/location/view/index/id/'.$data->id.'">'.$data->city.'</a>';
			$row[] = '<a href="/location/view/index/id/'.$data->id.'">'.$data->state.'</a>';
			$row[] = '<a href="/location/view/index/id/'.$data->id.'">'.$data->zip.'</a>';
 			$rows[] = $row;
		}
		
		$tableArray = array();
		
				
		$tableArray['recordsTotal'] = $datas->getTotalItemCount();
		$tableArray['recordsFiltered'] = $datas->getTotalItemCount();
		
		$tableArray['data'] = $rows;
		
			
		echo Zend_Json::encode($tableArray, true);
		exit;
	}
}