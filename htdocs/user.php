<?php
require_once('../libinc/user.php');
	
switch ($_REQUEST['action']){
	// Login a user
	case 'login':
		echo User::login($_REQUEST['user'], $_REQUEST['pass'], isset($_REQUEST['direct']));
		break;
		
	// Register a user
	case 'register':
		echo User::register($_REQUEST['user'], $_REQUEST['pass'], $_REQUEST['email'], $_REQUEST['first'], $_REQUEST['last'], isset($_REQUEST['direct']));
		break;
		
	// Make sure a username doesn't already exist
	case 'check':
		echo User::check($_REQUEST['user']); // don't care if direct, 1 or 0
		break;
	
	// Process a forgotten password
	case 'forgot':
		echo User::forgot(isset($_REQUEST['direct']));
		break;
	
	// Logout a user
	case 'logout':
		echo User::logout(isset($_REQUEST['direct']));
		break;
	
	// Verify a logged in and permissable user
	case 'checkLogged':
		echo User::checkLogged();
		break;
		
	// Fun messing with people
	default :
		echo "Your kung-fu is no good here";
		break;
}
?>