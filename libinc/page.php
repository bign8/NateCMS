<?php

class PageClass {
	public $pageVals	= array();
	public $content		= array();
	public $dynInclude	= array();
	public $blocks		= array();
	
	// bolean values for page magic
	private $is404		= false;
	private $isEditer	= false;
	
	// handles for things
	private $dbh; // DataBase Handle
	
	public function __construct(){
		$this->dbh = new mysqlClass();
	}
	
	public function Run() {
		$page= $_SERVER['REDIRECT_URL']; // or 'SCRIPT_URL'
		if(strrchr($page, "/") == "/") $page .= 'index'; // add index to each directory
		self::getPage($page);
		
		$smarty	= new SmartyConfig();
		$tpl	= $smarty->createTemplate('runner.tpl');
		
		//*
		$tpl->assign('header',		$this->pageVals['header']); // just pass whole array
		$tpl->assign('body',		$this->pageVals['body']); // would have to rewrite pagevals
		$tpl->assign('footer',		$this->pageVals['footer']); // see below for attempt
		$tpl->assign('keywords',	$this->pageVals['keywords']);
		$tpl->assign('desc',		$this->pageVals['description']);
		$tpl->assign('title',		$this->pageVals['title']);
		$tpl->assign('vfsID',		$this->pageVals['vfsID']);//*/
		
		//$tpl->assign('pageVals', $this->pageVals); // smarty test - fail :(
		
		$tpl->assign('content',		$this->content);
		$tpl->assign('dynInclude',	$this->dynInclude);
		$tpl->assign('blocks',		$this->blocks);
		$tpl->assign('isEditer',	$this->isEditer);
		$tpl->assign('is404',		$this->is404);
		
		$tpl->display();
	}
	
	private function getPage($url) {
		$edit = (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'edit');
		
		$url = $this->dbh->clean($url);
		
		$q = "SELECT * FROM `web_v_page` WHERE `path`='{$url}'";
		$pageQuery = $this->dbh->runQuery($q);
		
		if ( mysql_num_rows($pageQuery) != 0 ) {
			$rec = mysql_fetch_assoc($pageQuery);
			$this->pageVals = $rec;
			
			// update time on login certificate or remove cookie if not logged in
			if ( ! User::verify(false) ) { 
				setcookie('hash', '', time() - 3600);
			} else {
				User::refresh();
			}
			
			// has editing privliges for location
			$this->isEditer = User::verify();
			
			// Edit specefic processing
			if ( $edit ) {
				
				// Check credentials!
				if (!$this->isEditer) die("<script>alert('You are not authorized to edit this web page.\\nIf you feel this is an error, please contact the Webmaster.');window.location.href = \"{$_SERVER['REDIRECT_URL']}\";</script>");
				
				// add block names for edit mode
				$q = "SELECT blockID, name, description FROM `web_block`";
				$this->blocks = $this->dbh->fetchAllAssoc($q);
			}
			
			// get page content
			$q = "SELECT * FROM `web_v_content` WHERE `vfsID`='{$rec['vfsID']}'";// ORDER BY `orders` ASC"; // done by view
			$contentQuery = $this->dbh->runQuery($q);
			while ($row = mysql_fetch_assoc($contentQuery)) {
				$this->content[$row['locName']][] = $row; // special encoding, no fetchAllAssoc possible
			}
			
			// load dynamic includes
			$q = "SELECT * FROM `web_v_scripts` WHERE `edit` = '".($edit?'yes':'no')."' AND `blockID` IN (SELECT distinct(blockID) FROM web_content WHERE vfsID = {$rec['vfsID']}) ORDER BY `loadOrder` ASC;"; // optimize this query
			$this->dynInclude = $this->dbh->fetchAllAssoc($q);
			
		} else {
			// send proper error messages including refferer and client ip address
			
			$this->is404 = true;
			self::getPage("/404");
		}
	}
}
