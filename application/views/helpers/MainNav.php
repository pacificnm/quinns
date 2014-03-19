<?php
class View_Helper_MainNav
{
	public function MainNav()
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$auth = Zend_Auth::getInstance();
		$param = $auth->getIdentity();
		
		$menuModel = new Application_Model_Menu();
		$menuItems = $menuModel->load();
		
		$identity = $auth->getIdentity();

		
		echo '
		<div class="grid_16">
			<div class="   fullpage">		
			<div class="buttons">
				<a href="/index/index" class="button left" title="Home"><span class="icon icon108"></span></a>;
				';
			
		foreach($menuItems as $item){
			echo '<a href="'.$item->link.'" class="button middle" title="'.$item->title.'"><span class="icon '.$item->icon.'"></span><span class="label">'.$item->title.'</span></a>
				';
				
		}
		
		// reports
		echo '
		<div class="dropdown left">
			 <a href="#" class="button right"><span class="icon icon137"></span><span class="label">Reports</span><span class="toggle"></span></a>
			 <div class="dropdown-slider">
				<a href="/report/selected-site/all" class="ddm" title="Selected Sites"><span class="icon icon108"></span><span class="label">Selected Sites</span></a>
				<a href="/report/scheduled-service" class="ddm" title="Scheduled Services"><span class="icon icon108"></span><span class="label">Services</span></a>
				<a href="/schedule/index" class="ddm" title="Service Due"><span class="icon icon108"></span><span class="label">Service Due</span></a>';
				
		if($identity['acl'] == 'admin') {
			echo '<a href="/report/audit" class="ddm" title="Audit Reports"><span class="icon icon108"></span><span class="label">Audit</span></a>';
			echo '<a href="/report/security" class="ddm" title="Security Report"><span class="icon icon108"></span><span class="label">Security</span></a>';
				
		}
			      
		echo '	</div>
		</div>';
		
		if($identity['acl'] == 'admin') {
			echo '
			<div class="dropdown right">
			    <a href="#" class="button right"><span class="icon icon96"></span><span class="label">Admin</span><span class="toggle"></span></a>
			    <div class="dropdown-slider">
			      <a href="/admin" class="ddm" title="Admin Home"><span class="icon icon108"></span><span class="label">Home</span></a>
			       <a href="/employee/admin/index" class="ddm"><span class="icon icon194"></span><span class="label">Employee</span></a>
				   <a href="/admin/list/index" class="ddm"><span class="icon icon120"></span><span class="label">Lists</span></a>
				   <a href="/admin/module" class="ddm"><span class="icon icon53"></span><span class="label">Modules</span></a>
						      
			    </div>
			</div>';		
		}	
				
		echo '</div></div>
		</div>
		<div class="clear"></div>
		';
		
		
	}
}