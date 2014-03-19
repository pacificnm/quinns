<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application/'));
define('APPLICATION_ENVIRONMENT', 'development');

/**
 * Setup for includes
*/
set_include_path(
APPLICATION_PATH . '/../library' . PATH_SEPARATOR .
APPLICATION_PATH . '/../application/models' . PATH_SEPARATOR .
APPLICATION_PATH . '/../application/extends'. PATH_SEPARATOR .
get_include_path());


/**
 * Zend Autoloader
*/
require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();

/**
 * Register my Namespaces for the Autoloader
*/
$autoloader->registerNamespace('My_');
$autoloader->registerNamespace('Db_');


/**
 * Include my complete Bootstrap
 * @todo change when time is left
*/
require '../application/bootstrap.php';

/**
 * Setup the CLI Commands
 * ../application/cli.php --add
 * ../application/cli.php --scan
 * ..
 */
try {
	$opts = new Zend_Console_Getopt(
			array(
					'help'      => 'Displays usage information.',
					'add'       => 'Add the Feeds to the Pipe',
					'scan'      => 'Scan the Feeds in the Pipe',
					'que'       => 'Process the Pipe',
			)
	);

	$opts->parse();

} catch (Zend_Console_Getopt_Exception $e) {
	exit($e->getMessage() ."\n\n". $e->getUsageMessage());
}

if(isset($opts->help)) {
	echo $opts->getUsageMessage();
	exit;
}

/**
 * Action : add
 */
if(isset($opts->add)) {
	// do something
}

/**
 * Action : scan
 */
if(isset($opts->scan)) {
	// do something
}

/**
 * Action : que
 */
if(isset($opts->que)) {
	// do something
}