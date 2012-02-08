<?php
	class config {
		const hostDir = __DIR__;
		
		const hashMAGIC = '086a77f316feea410d2be37e2595d0e4'; // md5(th1$-Is_s@p#r*s3Kr3t!)
	
		##################################################
		# Email Configuration                            #
		##################################################
		/*
			These setting are used for the PHPMailer Class for sending 
			email from forms and error reports.
		*/
		const smtpServer = 'smtp.outsidemedia.com';
		const smtpPort = 25;
		const smtpAuth = false;
	
		##################################################
		# Database Constants                             #
		##################################################
		/*
			Variables below are for database access and should always be 
			constants to reduce injection attacks and stop programmatically
			changing of them.
		*/
		const mysql_Host = 'outsidemediacom.fatcowmysql.com';
		const mysql_UserName = 'webaccess';
		const mysql_Password = '7GvUiLZMJvNo5dvc4nYh';
		const mysql_WebDB = 'omnate';
	
		##################################################
		# ErrorClass Constants                           #
		################################################## 
		/*
			Variables used in ErrorClass.php for error reporting and sending emails 
			alerting admin of problems with the website operation.
		*/
		static $errorApp = '';
		static $errorSubject = '';
		
		const webprog = 'webprog@outsidemedia.edu';
		const webprogFrom = 'OM Web Programmer';
	
		##################################################
		# XML Output Constants                           #
		##################################################
		/*
			Used for web admin constant variables
		*/
		const xmlLead = "<?xml version='1.0' encoding='utf-8'?>\n<data>\n";
		const xmlTail = "</data>\n";
	}
?>