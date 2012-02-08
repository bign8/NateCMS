<?php
require_once("site_inc.php");

class User {
	const LOGIN_SUCCESS = "<h1 class='yay'>Success</h1><p>You will be redirected in 4 seconds.</p>",
		  LOGIN_SCREEN = "<h1 class='err'>Error</h1><p>Sorry, your account has not been authenticated by the control user.  Please try again later.</p>",
		  LOGIN_ERROR = "<h1 class='err'>Error</h1><p>Sorry, your account could not be found. Please try again.</p>",
		  REGISTER_SUCCESS = "<h1 class='yay'>Success</h1><p>Your account was successfully created. Please wait for an e-mail from the Control User.</p>",
		  REGISTER_DUPLICATE = "<h1 class='err'>Error</h1><p>Sorry, that username is taken. Please go back and try again.</p>",
		  REGISTER_ERROR = "<h1 class='err'>Error</h1><p>Sorry, your registration failed. Please go back and try again.</p>",
		  LOGOUT_SUCCESS = "<h1 class='yay'>Success</h1><p>You have been successfully logged out!</p>";
	
	public function User() {
		// verify and get permissions - admin?
		// store in an array and allow access
	}
	
	// verify that user is still logged in and has permissions
	public static function verify($edit = true) { // more like isEdit
		$dbConn = new mysqlClass();
		
		// allow age-ing of hashes ( one minute after all instances closed lose privlages )
		$dbConn->runQuery("DELETE FROM `webAuthedUsers` WHERE `created` < TIMESTAMPADD( MINUTE, -1, NOW() )");
		
		$access = false;
		$cleanHash = $dbConn->clean( $_COOKIE['hash'] );
		$perms = $dbConn->runQuery("SELECT * FROM `vWebPerms` WHERE `userHash` = '$cleanHash'");
		
		while (!$access && $accRow = mysql_fetch_assoc($perms)) {
			if( strpos($_SERVER['REQUEST_URI'], $accRow['permPath']) === 0 || !$edit) $access = true;
		}
		
		return $access;
	}
	
	// update timestamp on logged in users
	public static function refresh() {
		if (!isset($_COOKIE['hash'])) return;
	
		$dbConn = new mysqlClass();
		$cleanHash = $dbConn->clean( $_COOKIE['hash'] );
		$dbConn->runQuery("UPDATE `webAuthedUsers` SET `created` = NOW( ) WHERE `userHash` = '$cleanHash' LIMIT 1 ;");
	}
	
	// webfunction to logout of all instances! checks if db changes (authenticon and permissions)
	function checkLogged() {
		$editing = ! (false === strpos(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY).'a', "mode=edit"));
		
		// check validation
		if ( User::verify(false) ) {
			User::refresh();
			
			 // check permission changes
			if ($editing) return (User::verify()) ? '1' : '0' ;
			
			return '1';
		}
		setcookie('hash', '', time() - 3600);
		return '0';
	}
	
	// login user (web form function)
	function login($user, $pass, $direct){
		$dbConn = new mysqlClass();
		
		$username = $dbConn->clean($user);
		$password = $dbConn->clean($pass);
		
		$checklogin = $dbConn->runQuery("SELECT `userID` FROM `webUsers` WHERE `userName` = '$username' AND `password` = sha1('$password')");

		if(mysql_num_rows($checklogin) == 1) {
			$row = mysql_fetch_array($checklogin);
			
			// http://php.net/manual/en/function.sha1.php - derived from first comment
			$hash = base64_encode(sha1($password . sha1($row['userID'] . rand())) . sha1($row['userID'] . rand()) . config::hashMAGIC);
			
			// make sure hasn't already logged in! - unique field
			$dbConn->runQuery("INSERT INTO `webAuthedUsers` (`userID`, `userHash` ) VALUES ('" . $row['userID'] . "', '$hash');");
			$hasHash = mysql_fetch_array($dbConn->runQuery("SELECT `userHash` FROM `webAuthedUsers` WHERE authID = LAST_INSERT_ID() OR userID = '" . $row['userID'] . "'"));
			
			setcookie('hash', $hasHash['userHash']);
			$d = array("msg" => self::LOGIN_SUCCESS);
		} else {
			$d = array("msg" => self::LOGIN_ERROR);
		}
		
		if ($direct) return self::direct_handler($d);
		return json_encode($d);
	}
	
	// register user
	function register($user, $pass, $email, $first, $last){
		return "Who would want to register a snot nosed kid anyhow??";
	}
	
	// check to see if username already exists
	function check($user) {
		return 'to hell if I know!';
	}
	
	// recover user credentials
	function forgot(){
		return 'so did I';
	}
	
	// logout a user (web form function)
	function logout($direct){
		$dbConn = new mysqlClass();
		$dbConn->runQuery("DELETE FROM `webAuthedUsers` WHERE `userHash` = '" . $dbConn->clean($_COOKIE['hash']) . "' LIMIT 1");
		setcookie('hash', '', time() - 3600);
		$d = array("msg" => self::LOGOUT_SUCCESS);
		if ($direct) return self::direct_handler($d);
		return json_encode($d);
	}
	
	// output for direct access to script, login forms on non-js browers, etc ... 
	private function direct_handler($stateArr){
		$returnHTML  = "<html><head>";
		$returnHTML .= "<META HTTP-EQUIV=\"refresh\" CONTENT=\"4;URL=" . $_SERVER['HTTP_REFERER'] . "\">";
		$returnHTML .= "</head><body>";
		$returnHTML .= $stateArr['msg'];
		$returnHTML .= "<p><a href='" . $_SERVER['HTTP_REFERER'] . "'>If you are not redirected momentarily</a></p>";
		$returnHTML .= "</body></html>";
		return $returnHTML;
	}
}

?>