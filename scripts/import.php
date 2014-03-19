<?php
// Load the shared common file...
$base = dirname(dirname(realpath(__FILE__)));
require_once($base . '/common.php');

// Here we show a basic example of using simple operators:
try {
	$opts = new Zend_Console_Getopt('b:p:');
	$options = $opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	echo $e->getUsageMessage();
	exit;
}
ini_set('max_execution_time', 0);
ini_set('memory_limit','1600M');

$wellModel = new Well_Model_Well();
$oldWellData = $wellModel->loadOldData();