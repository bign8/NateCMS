<?php
include("../libinc/edit.php");

if (User::verify() == '') die("Your Kung-Fu is not strong!"); // ensure authenticated
// now ensure rights to edit

switch ($_REQUEST['action']) {
	case 'updateOrder':
		echo Edit::updateOrder($_REQUEST['data']);
		break;
	case 'removeContent':
		echo Edit::removeContent($_REQUEST['remID']);
		break;
	case 'addContent':
		echo Edit::addContent($_REQUEST['vfsID'], $_REQUEST['loc'], $_REQUEST['blockID']);
		break;
	case 'updateContent':
		echo Edit::updateContent($_REQUEST['cID'], $_REQUEST['content']);
		break;
	
	default:
		echo "Your Kung-Fu is not strong!";
}
?>