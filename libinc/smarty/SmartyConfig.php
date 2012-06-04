<?php
	//Load Smarty Library
	require('../Smarty-3.1.4/libs/Smarty.class.php');
	
	//Base class for website. This class sets the directory storage for 
	//all Smarty files used in the website.
	class SmartyConfig extends Smarty {
		function __construct(){
			parent::__construct();
			
			// from web root
			$this->template_dir = config::hostDir . '/smarty/templates/';
			$this->compile_dir = config::hostDir . '/smarty/templates_c/';
			$this->config_dir = config::hostDir . '/smarty/config/';
			$this->cache_dir = config::hostDir . '/smarty/cache/';
			
			$this->caching = false;
			$this->assign('app_name', config::AppName);
			
			//$this->testInstall();
			
			// Nate Added
			//$this->config_overwrite = false;
			//$this->php_handling = SMARTY_PHP_PASSTHRU;
			//$this->PHP_PASSTHRU = true;
			//$this->debugging = true;
		}
	}
?>