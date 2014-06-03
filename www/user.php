<?php
require_once('../libinc/user.php');

if (!isset($_REQUEST['action'])) die("Your kung-fu is no good here");
switch ($_REQUEST['action']){
	// Login a user
	case 'login':
		echo User::login($_REQUEST['user'], $_REQUEST['pass'], isset($_REQUEST['direct']), $_REQUEST['referer']);
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
		echo User::logout(isset($_REQUEST['direct']), $_REQUEST['referer']);
		break;
	
	// Verify a logged in and permissable user
	case 'checkLogged':
		echo User::checkLogged();
		break;
	
	
	// -------------------- HTML FUNCTIONS
	// Direct Login
	case 'forceLogin':
		if($_SERVER['HTTPS']!=='on'){ // force secure
			header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			die();
		}
		$referer = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : ("http://".$_SERVER['HTTP_HOST']) ;
		echo <<<END
<!doctype html>
<html>
	<head>
		<style type="text/css">
			body{height:100%;width:100%;margin:0;padding:0}
			form{width:260px;height:130px;position:absolute;left:50%;top:50%;margin:-65px 0 0 -135px;padding:0 10px;border:1px solid black;background-color:white;text-align:center}
			input{width:100%}
			h3{margin:10px 0 0 0}
		</style>
	</head>
	<body>
		<form id="webLogin" action="user.php" method="post" name="webLogin">
			<input type="hidden" name="referer" value="$referer">
			<input type="hidden" name="direct" value="true">
			<input type="hidden" name="action" value="login">
			<h3>Web Administration Login</h3>
			<table width="100%">
				<tbody>
					<tr>
						<td><label for="username">Username:</label></td>
						<td><input id="username" type="text" name="user" width="100%"></td>
					</tr><tr>
						<td><label for="password">Password:</label></td>
						<td><input id="password" type="password" name="pass" width="100%"></td>
					</tr><tr>
						<td><input type="reset" value="Cancel" onclick="window.location.assign('$referer')" /></td>
						<td><input type="submit" value="Login" /></td>
					</tr>
				</tbody>
			</table>
		</form>
	</body>
</html>
END;
		break;
	
	// Direct logout
	case 'forceLogout':
		if($_SERVER['HTTPS']!=='on'){ // force secure
			header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			die();
		}
		$referer = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : ("http://".$_SERVER['HTTP_HOST']) ;
		echo <<<END
<!doctype html>
<html>
	<head>
		<style type="text/css">
			body{height:100%;width:100%;margin:0;padding:0}
			form{width:270px;height:65px;position:absolute;left:50%;top:50%;margin:-33px 0 0 -135px;padding:0 10px;border:1px solid black;background-color:white;text-align:center}
			input{width: 100%}
			h3{margin:10px 0 0 0}
		</style>
	</head>
	<body>
		<form id="webLogin" action="/user.php" method="post" name="webLogin">
			<input type="hidden" name="referer" value="$referer">
			<input type="hidden" name="direct" value="true" />
			<input type="hidden" name="action" value="logout" />
			<h3>Web Administration Logout</h3>
			<table width="100%">
				<tr>
					<td><input type="reset" value="Cancel" onclick="window.location.assign('$referer')" /></td>
					<td><input type="submit" value="Logout" /></td>
				</tr>
			</table>
		</form>
	</body>
</html>	
END;
		break;
	
	// Fun messing with people
	default :
		echo "Your kung-fu is no good here";
		break;
}
