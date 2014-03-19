<?php 
class View_Helper_Breadcrumb
{
	
	public function Breadcrumb($breadcrumbs)
	{
		/**$html = '<div class="grid_16">
					<div class="fullpage breadcrumb">
						<a href="/index" title="Home">Home</a> / </li>';
		
		if(!empty($breadcrumbs)) {
		
			foreach($breadcrumbs as $breadcrumb) {
				if($breadcrumb['last']) {
					$html .= $breadcrumb['title'];
				} else {
					$html .= '<a href="'.$breadcrumb['url'].'" title="'.$breadcrumb['title'].'">'.$breadcrumb['title'].'</a> / ';
				}
			}
		}

		$html .='</div></div>
				<div class="clear"></div>';
		
		return $html;*/
	}
}
