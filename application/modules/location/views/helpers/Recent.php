<?php
class Location_View_Helper_Recent extends Zend_View_Helper_Action
{
	
	public function Recent($location)
	{
		$authModel = Zend_Auth::getInstance();
		$auth = $authModel->getIdentity();
	
		
		$recentModel = new Location_Model_RecentLocation();
		$recents = $recentModel->loadByEmployee($auth['employeeId'], $location);
		
		
		
		$html = '<div class="box round first"><h2>Recent Locations</h2>
		<div class="block" id="section-menu"><ul class="section menu">';
		
		foreach($recents as $recent) {
			$html .= '<li><a href="/location/view/index/id/'.$recent->location_id.'" title="" class="menuitem">'.$this->_truncate($recent->street, 18).'</a></li>';
		}
		
		$html .= '</ul></div></div>';
		
		return $html;
	}
	
	private function _truncate($string, $max=25)
	{
		if(strlen($string) > $max ) {
			$newString = substr($string, 0, $max) . "...";
			return $newString;
		} else {
			return $string;
		}
	}
}