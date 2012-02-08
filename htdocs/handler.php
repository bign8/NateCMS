<?php
	require_once('../libinc/site_inc.php');
	
	class thisPage extends PageClass {
		function awesome(){
			// Magic happens here!
		}
	}
	
	// rewrite so db is all sqlite - see: http://www.switchonthecode.com/tutorials/php-tutorial-creating-and-modifying-sqlite-databases
	// admin note - when new directory is created, automatically generate index file for new directory
	$page = new thisPage();
	$page->Run();
?>