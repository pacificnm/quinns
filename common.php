<?php
// Define the library path
define('BASE_PATH', dirname(realpath(__FILE__)));
define('LIBRARY_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'library');

// Add library path to PHP include path
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), LIBRARY_PATH)));

// Load Zend Autoloader
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);