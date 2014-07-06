<?php
class Owner_JsonController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function browseAction()
    {
        $locationId = $this->getParam('location_id');
    
        $order = $this->getParam('order');
		$column = (int) $order[0]['column'];
		$dir = $order[0]['dir'];
		
		$sortColumnArray = array('name', 'phone', 'street', 'city', 'state', 'zip' );
		$sortColumn = $sortColumnArray[$column];
		
		//echo $sortColumn;
		
		
		$omo = new Owner_Model_Owner();
		$Lml = new Location_Model_Location();
		
		
		$iDisplayStart = (int) $this->getParam('start', 0);
		$iDisplayLength = (int) $this->getParam('length', 10);
		
		$search = $this->getParam('search', 'name');
		
		
		$page = ($iDisplayStart / $iDisplayLength) + 1;
			
		$datas = $omo->browse($page, $iDisplayLength, $search['value'], $sortColumn, $dir);
		
		
		
		$rows = array();
		$i = 0;
		foreach($datas as $data) {
			$row = array();
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->name.'</a>';
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->phone.'</a>';
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->street.'</a>';
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->city.'</a>';
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->state.'</a>';
			$row[] = '<a href="/owner/view/index/id/'.$data->id.'">'.$data->zip.'</a>';
			if($locationId > 0) {
			$row[] = '<select name="" id="ownerType_'.$data->id.'"><option value="Owner">Owner</option><option value="Renter">Renter</option><option value="Realtor">Realtor</option></select>';
			$row[] = '<input type="submit" name="check'.$i.'" class="some-class" value="Add" id="button_'.$data->id.'" onclick="f1('.$data->id.');">';
			}
 			$rows[] = $row;
 			$i++;
		}
		
		$tableArray = array();
		
				
		$tableArray['recordsTotal'] = $datas->getTotalItemCount();
		$tableArray['recordsFiltered'] = $datas->getTotalItemCount();
		
		$tableArray['data'] = $rows;
	
			
		echo Zend_Json::encode($tableArray, true);
		exit;
    }
}   