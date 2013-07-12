<?php
	class PageClass {
		public static $pageVals = array();
		public static $content = array();
		public static $dynInclude = array();
		public static $blocks = array();
		
		// bolean values for page magic
		private static $is404 = false;
		private static $isEditer = false;
		
		// handles for things
		private static $dbConn;
		
		public function __construct(){
			self::$dbConn = new mysqlClass();
		}
		
		public function Run() {
			$page= $_SERVER['REDIRECT_URL']; // or 'SCRIPT_URL'
			if(strrchr($page, "/") == "/") $page .= 'index'; // add index to each directory
			self::getPage($page);
			
			$smarty = new SmartyConfig();
			$tpl = $smarty->createTemplate('runner.tpl');
			
			//*
			$tpl->assign('header', self::$pageVals['header']); // just pass whole array
			$tpl->assign('body', self::$pageVals['body']); // would have to rewrite pagevals
			$tpl->assign('footer', self::$pageVals['footer']); // see below for attempt
			$tpl->assign('keywords', self::$pageVals['keywords']);
			$tpl->assign('desc', self::$pageVals['description']);
			$tpl->assign('title', self::$pageVals['title']);
			$tpl->assign('vfsID', self::$pageVals['vfsID']);//*/
			
			//$tpl->assign('pageVals', self::$pageVals); // smarty test - fail :(
			
			$tpl->assign('content', self::$content);
			$tpl->assign('dynInclude', self::$dynInclude);
			$tpl->assign('blocks', self::$blocks);
			$tpl->assign('isEditer', self::$isEditer);
			$tpl->assign('is404', self::$is404);
			
			$tpl->display();
		}
		
		private function getPage($url) {
			$edit = (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'edit');
			
			$url = self::$dbConn->clean($url);
			
			$q = "SELECT * FROM `vWebPages` WHERE `path`='" . $url . "'";
			$pageQuery = self::$dbConn->runQuery($q);
			
			if ( mysql_num_rows($pageQuery) != 0 ) {
				$rec = mysql_fetch_assoc($pageQuery);
				self::$pageVals = $rec;
				
				// update time on login certificate or remove cookie if not logged in
				if ( ! User::verify(false) ) { 
					setcookie('hash', '', time() - 3600);
				} else {
					User::refresh();
				}
				
				// has editing privliges for location
				self::$isEditer = User::verify();
				
				// Edit specefic processing
				if ( $edit ) {
					
					// Check credentials!
					if (!self::$isEditer) die("<script>alert('You are not authorized to edit this web page.\\nIf you feel this is an error, please contact the Webmaster.');window.location.href = \"{$_SERVER['REDIRECT_URL']}\";</script>");
					
					// add block names for edit mode
					$q = "SELECT blockID, name, description FROM `webBlock`";
					self::$blocks = self::$dbConn->fetchAllAssoc($q);
				}
				
				// get page content
				$q = "SELECT * FROM `vWebCon` WHERE `vfsID`='" . $rec['vfsID'] . "'";// ORDER BY `orders` ASC"; // done by view
				$contentQuery = self::$dbConn->runQuery($q);
				while ($row = mysql_fetch_assoc($contentQuery)) {
					self::$content[$row['locName']][] = $row; // special encoding, no fetchAllAssoc possible
				}
				
				// load dynamic includes
				$q = "SELECT * FROM `vWebScripts` WHERE `edit` = ".((int)$edit)." AND `blockID` IN (SELECT distinct(blockID) FROM webContent WHERE vfsID = ".$rec['vfsID'].")";
				self::$dynInclude = self::$dbConn->fetchAllAssoc($q);
				
			} else {
				// send proper error messages including refferer and client ip address
				
				self::$is404 = true;
				self::getPage("/404");
			}
		}
	}
?>