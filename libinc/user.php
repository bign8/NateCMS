<?php

require_once("site_inc.php");

class User {
	const LOGIN_SUCCESS			= "<h1 class='yay'>Success</h1><p>You will be redirected in 4 seconds.</p>",
		  LOGIN_SCREEN			= "<h1 class='err'>Error</h1><p>Sorry, your account has not been authenticated by the control user.  Please try again later.</p>",
		  LOGIN_ERROR			= "<h1 class='err'>Error</h1><p>Sorry, your account could not be found. Please try again.</p>",
		  REGISTER_SUCCESS		= "<h1 class='yay'>Success</h1><p>Your account was successfully created. Please wait for an e-mail from the Control User.</p>",
		  REGISTER_DUPLICATE	= "<h1 class='err'>Error</h1><p>Sorry, that username is taken. Please go back and try again.</p>",
		  REGISTER_ERROR		= "<h1 class='err'>Error</h1><p>Sorry, your registration failed. Please go back and try again.</p>",
		  LOGOUT_SUCCESS		= "<h1 class='yay'>Success</h1><p>You have been successfully logged out!</p>";
	
	public function User() {
		// verify and get permissions - admin?
		// store in an array and allow access
	}
	
	// verify that user is still logged in and has permissions
	public static function verify($edit = true) { // more like isEdit
		$DBH = new myPDO();
		
		// allow age-ing of hashes ( one minute after all instances closed lose privlages )
		$DBH->query("DELETE FROM `web_authedUsers` WHERE `created` < TIMESTAMPADD( MINUTE, -1, NOW() );");
		
		$access = false;
		if (isset($_COOKIE['hash'])) {
		
			$STH = $DBH->prepare("SELECT * FROM `web_v_perms` WHERE `userHash` = ? ;");
			$STH->execute( $_COOKIE['hash'] );

			while (!$access && $accRow = $STH->fetch( PDO::FETCH_ASSOC )) {
				if( strpos($_SERVER['REQUEST_URI'], $accRow['permPath']) === 0 || !$edit) $access = true;
			}
		}
		
		return $access;
	}
	
	// update timestamp on logged in users
	public static function refresh() {
		if (!isset($_COOKIE['hash'])) return;
	
		$DBH = new myPDO();
		$STH = $DBH->prepare("UPDATE `web_authedUsers` SET `created` = NOW( ) WHERE `userHash` = ? LIMIT 1 ;");
		$STH->execute( $_COOKIE['hash'] );
	}
	
	// webfunction to logout of all instances! checks if db changes (authenticon and permissions)
	function checkLogged() {
		$editing = ! (false === strpos(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY).'a', "mode=edit")); // WHAT? is there a better way to do this?
		
		// check validation and permissions
		if ( User::verify($editing) ) {
			User::refresh();
			return '1';
		}
		
		setcookie('hash', '', time() - 3600);
		return '0';
	}
	
	// login user (web form function)
	function login($user, $pass, $direct, $ref=false){
		$DBH = new myPDO();

		$loginSTH = $DBH->prepare("SELECT `userID` FROM `web_users` WHERE `userName` = ? AND `password` = sha1( ? );");
		$loginSTH->execute( $user, $pass );

		if($loginSTH->rowCount() == 1) {
			$row = $loginSTH->fetch( PDO::FETCH_ASSOC );
			
			// http://php.net/manual/en/function.sha1.php - derived from first comment
			$hash = base64_encode(sha1($pass . sha1($row['userID'] . rand())) . sha1($row['userID'] . rand()) . config::hashSALT); // is there a better way?
			
			// make sure hasn't already logged in! - unique field
			$insertSTH = $DBH->prepare("INSERT INTO `web_authedUsers` (`userID`, `userHash` ) VALUES ( ?, ? );"); // find a way to skip errors here so next step can fire
			$insertSTH->execute( $row['userID'], $hash );

			$authSTH = $DBH->prepare("SELECT `userHash` FROM `web_authedUsers` WHERE authID = LAST_INSERT_ID() OR userID = ? ;");
			$authSTH->execute( $row['userID'] );
			$hasHash = $authSTH->fetch( PDO::FETCH_ASSOC );
			
			setcookie('hash', $hasHash['userHash']);
			$d = array("msg" => self::LOGIN_SUCCESS, "reload" => true);
		} else {
			$d = array("msg" => self::LOGIN_ERROR, "reload" => false);
		}
		
		if ($direct) return self::direct_handler($d, $ref);
		return json_encode($d);
	}
	
	// TODO: register user
	function register($user, $pass, $email, $first, $last){
		return "Who would want to register a snot nosed kid anyhow??";
	}
	
	// TODO: check to see if username already exists
	function check($user) {
		return 'to hell if I know!';
	}
	
	// TODO: recover user credentials
	function forgot(){
		return 'so did I';
	}
	
	// logout a user (web form function)
	function logout($direct, $ref=false){
		$DBH = new myPDO();
		$STH = $DBH->prepare("DELETE FROM `web_authedUsers` WHERE `userHash` = ? ;");
		$STH->execute( $_COOKIE['hash'] );

		setcookie('hash', '', time() - 3600);
		$d = array("msg" => self::LOGOUT_SUCCESS);
		if ($direct) return self::direct_handler($d, $ref);
		return json_encode($d);
	}
	
	// output for direct access to script, login forms on non-js browers, etc ... 
	private function direct_handler($stateArr, $ref){
		if (!$ref) $ref = $_SERVER['HTTP_REFERER'];
		$returnHTML  = "<html><head>";
		$returnHTML .= "<META HTTP-EQUIV=\"refresh\" CONTENT=\"4;URL=" . $ref . "\">";
		$returnHTML .= "</head><body>";
		$returnHTML .= $stateArr['msg'];
		$returnHTML .= "<p><a href='" . $ref . "'>If you are not redirected momentarily</a></p>";
		$returnHTML .= "</body></html>";
		return $returnHTML;
	}
}
