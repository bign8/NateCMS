<?php
	set_magic_quotes_runtime(0); 
	ini_set('display_errors', 1);
	
	if ( !defined('__DIR__') ) define('__DIR__', dirname(__FILE__)); // php < 5.3.0 fix
	
	require_once('config.php');
	require_once('db.php');
	require_once('smarty/SmartyConfig.php');
	require_once('page.php');
	require_once(__DIR__ . '/user.php');
?>