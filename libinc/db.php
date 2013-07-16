<?php

// http://www.switchonthecode.com/tutorials/php-tutorial-creating-and-modifying-sqlite-databases

class myPDO extends PDO {
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
