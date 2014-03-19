<?php
/**
 * 
 * @author Jaimie
 *
 */
class Admin_View_Helper_AdminNav extends Zend_View_Helper_Action
{
	/**
	 * 
	 * @param unknown_type $employeeId
	 */
	public function AdminNav()
	{
		$front = Zend_Controller_Front::getInstance();
		
		$module = $front->getRequest()->getModuleName();
		
		// translate
		//$translate = Zend_Registry::get('Zend_Translate_Employee');
		
		$html = '
<div class="grid_16">
	<ul class="nav main">
				<li class="ic-gallery dd"><a href="/index/index" title=""><span>Home</span></a></li>
				<li class="ic-form-style"><a href="/client/index" title=""><span>Client</span></a></li>
				<li class="ic-dashboard"><a href="/employee/index" title=""><span>Employee</span></a>
					<ul>
						<li><a href="/mileage/view/index/" title="">Mileage</a></li>
						<li><a href="/task/view/employee/id/" "">Tasks</a></li>
						<li><a href="" title="">Workorders</a></li>
					</ul>
				</li>			
				<li class="ic-charts"><a href="/admin/index" title=""><span>Admin</span></a></li>
			</ul>
</div>
<div class="clear"></div>';
		
		return $html;
	}
		
	
}
	