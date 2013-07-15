<?php

class config {
	const hostDir   = __DIR__;
	const hashSALT = ''; // Random Private String for password encrypting process
	
	##################################################
	# General Server Configuration                   #
	##################################################
	/*
		This section is for general server configs that
		will be used all over
	*/
	const AppName = 'Name of the Application for errors';

	##################################################
	# Email Configuration                            #
	##################################################
	/*
		These setting are used for the PHPMailer Class for sending 
		email from forms and error reports.
	*/
	const smtpServer = 'your.mail-server.com';
	const smtpPort   = 25;
	const smtpAuth   = false;

	##################################################
	# Database Constants                             #
	##################################################
	/*
		Variables below are for database access and should always be 
		constants to reduce injection attacks and stop programmatically
		changing of them.
	*/
	const db_dsn	= 'PDO CONECTION STRING GOES HERE';
	const db_user	= null; // if mysql, db server username string
	const db_pass	= null; // if mysql, db server password string
	const db_opt	= null; // PDO connection options
	
	const mysql_Host     = 'your.mysql-host.com';
	const mysql_UserName = 'your.mysql.username';
	const mysql_Password = 'your.mysql.password';
	const mysql_WebDB    = 'your.mysql.site.database';

	##################################################
	# ErrorClass Constants                           #
	################################################## 
	/*
		Variables used in ErrorClass.php for error reporting and sending emails 
		alerting admin of problems with the website operation.
	*/
	static $errorApp     = '';
	static $errorSubject = '';
	
	const webprog     = 'your.email';
	const webprogFrom = 'your.title';

	##################################################
	# XML Output Constants                           #
	##################################################
	/*
		Used for web admin constant variables
	*/
	const xmlLead = "<?xml version='1.0' encoding='utf-8'?>\n<data>\n";
	const xmlTail = "</data>\n";
}
