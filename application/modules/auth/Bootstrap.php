<?php

class Auth_Bootstrap extends Zend_Application_Module_Bootstrap
{

	/**
	 *
	 */
	protected function _initTranslate() {
		// We use the Swedish locale as an example
		$locale = new Zend_Locale('en_US');
		Zend_Registry::set('Zend_Locale', $locale);
	
		// Create Session block and save the locale
		$session = new Zend_Session_Namespace('session');
		$langLocale = isset($session->lang) ? $session->lang : $locale;
			
		// Set up and load the translations (all of them!)
	
		$translate = new Zend_Translate('tmx', APPLICATION_PATH . '/modules/auth/languages/', $langLocale.'.ini',
				array('disableNotices' => false));
	
		//$translate->setLocale($langLocale); // Use this if you only want to load the translation matching current locale, experiment.
			
		// Save it for later
		$registry = Zend_Registry::getInstance();
		$registry->set('Zend_Translate', $translate);
	
	
	}
}

