<?php
	// sqlite http://www.switchonthecode.com/tutorials/php-tutorial-creating-and-modifying-sqlite-databases
	
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
			
			if (mysql_error(self::$db) != '') self::error_handle("Error in query!"/*: ".$query*/);
			
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
?>