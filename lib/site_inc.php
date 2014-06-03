<?php

set_magic_quotes_runtime(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ( !defined('__DIR__') ) define('__DIR__', dirname(__FILE__)); // php < 5.3.0 fix

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/db.php');
require_once('smarty/SmartyConfig.php');
require_once('page.php');
require_once(__DIR__ . '/user.php');
