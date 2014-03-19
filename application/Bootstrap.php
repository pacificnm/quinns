<?php
/**
 * Application Bootstrap class to bootstrap Application
 *
 * @author Jaimie Garner
 * @copyright 2013 Jaimie Garner
 *
 * @package Client
 * @category Bootstrap
 * @version 1.0
 *
 * @uses Zend_Application_Bootstrap_Bootstrap
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * 
	 * @return Zend_Application_Module_Autoloader
	 */
	protected function _initAppAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
				'namespace' => 'App',
				'basePath' => dirname(__FILE__),
		));
		return $autoloader;
	}
	
	protected function _initSessions() {
		$this->bootstrap('session');
	}
	
	/**
	 * 
	 */
	protected function _initJquery() {
	
		$this->bootstrap('view');
		$view = $this->getResource('view'); //get the view object
	
		//add the jquery view helper path into your project
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
	
		//jquery lib includes here (default loads from google CDN)
		$view->jQuery()->enable()//enable jquery ; ->setCdnSsl(true) if need to load from ssl location
		->setVersion('1.5')//jQuery version, automatically 1.5 = 1.5.latest
		->setUiVersion('1.8')//jQuery UI version, automatically 1.8 = 1.8.latest
		->addStylesheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css')//add the css
		->uiEnable();//enable ui
	
	}
	
	public function _initDate()
	{
		date_default_timezone_set('America/Los_Angeles');
	}
	
	
	public function _initPaginator()
	{
		
	}
	
	public function _initCache()
	{
		$cacheManager = new Zend_Cache_Manager();
		$frontendOptions = array(
				'lifetime' => 7200, // cache lifetime of 2 hours
				'automatic_serialization' => true
		);
		$backendOptions = array(
				'cache_dir' => APPLICATION_PATH . '/cache'
		);
		$coreCache = Zend_Cache::factory(
				'Core',
				'File',
				$frontendOptions,
				$backendOptions
		);
		$cacheManager->setCache('coreCache', $coreCache);
		$pageCache = Zend_Cache::factory(
				'Page',
				'File',
				$frontendOptions,
				$backendOptions
		);
		$cacheManager->setCache('pageCache', $pageCache);
	
		Zend_Registry::set('cacheMan', $cacheManager);
		return $cacheManager;
	}
	
	function _initRoutes() 
	{
		$frontController = Zend_Controller_Front::getInstance();
		 $router = $frontController->getRouter();
		  
		 //route
		 $route = new Zend_Controller_Router_Route(
		   '/page/content',
		   array(
		   	'module' => 'page',
		    'controller' => 'content',
		    'action' => 'index'
		   )
		 );
		 $router->addRoute('contactus', $route);
		
		/**
		print '<pre>';
		print_r($router);
		die;*/
	}
	
	public function _initControllerPlugin()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Application_Plugin_Initialization('production'));
	
	}
}

