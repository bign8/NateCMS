<?php

class mysqlClass{
	private static $db;
	
	function __construct(){
		self::dbConnect();
	}
	
	public function dbConnect(){
		$dbConn = @mysql_connect(config::mysql_Host, config::mysql_UserName, config::mysql_Password);
		if(!$dbConn){
			// Handle connection errors
			self::error_handle("Error Connecting to DB");
		} else {
			mysql_select_db(config::mysql_WebDB, $dbConn);
			self::$db = $dbConn;
		}
	}
	public function runQuery($query) { 
		$result = mysql_query($query, self::$db);
		
		if (mysql_error(self::$db) != '') self::error_handle("Error in query!: ".$query);
		
		return $result;
	}
	
	// fetch a single element in variable form from db
	public function fetchAssoc($query, $entry = NULL) {
		$result = mysql_fetch_assoc(self::runQuery($query));
		$result = (is_null($entry))?$result:$result[$entry];
		return $result;
	}
	
	// fetch a multi-level array from db
	public function fetchAllAssoc($query) {
		$ret = array();
		$data = self::runQuery($query);
		while ($row = mysql_fetch_assoc($data)) {
			$ret[] = $row;
		}
		return $ret;
	}
	
	public function getError() {
		return mysql_error(self::$db);
	}
	public function clean($string) {
		return mysql_real_escape_string($string, self::$db);
	}
	
	private function error_handle($msg) {
		// mail stuff here
		die (mysql_errno(self::$db) . ' db - error! ' . $msg); // 1062
	}
}

// possible rename to myPDO
class dbConnect extends PDO {
	public function __construct() {
		try {
			parent::__construct( config::db_dsn, config::db_user, config::db_pass, config::$db_opt );
		} catch (PDOException $e) {
			if( $_SERVER['REQUEST_URI'] != '/db404' ) { // to be implemented
				die($e->getMessage());
			}
		}
	}
	/*
	// another way to handle query errors
	public function query($params) { // may need more parameters
		return parent::query($params);
		// handle error
	}

	public function execute( $params ) { // may need more parameters
		parent::execute( $params );
		// handle error
	}
	//*/
}
