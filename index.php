<?php
// No display, log everything
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log',dirname(__FILE__).'/error.log');

// include everything
include_once 'FileToZip.php';
include_once 'FileToZipDispatcher.php';
include_once 'ToDownloadIndex.php';
include_once 'FileToZipEmail.php';

$action = filter_input(INPUT_GET, 'action');
$possibleActions = array('download', 'form', 'shortcut');

define('BASE_URL', 'http://mywebsite.com');

if($action == null || !in_array($action, $possibleActions)){
	header('HTTP/1.0 404 Not Found');
	exit;
}

if($action == 'form'){
	include_once 'index.html';
	exit;
}

if($action == 'download'){
	include_once 'download.php';
	exit;
}

if($action == 'shortcut'){
	include_once 'shortcut.php';
	exit;
}