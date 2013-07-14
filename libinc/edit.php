<?php
include("site_inc.php");

class Edit {
	// WARNING: Changing this will mess up the webConHistory table
	public static $NUM_OF_HISTORY = 5; 

	function updateContent($cid, $content) {
		$dbConn = new mysqlClass();
		
		// clean arguments
		$content = $dbConn->clean($content); $intCid = (int)$cid;
		if (!is_int($intCid)) return "No black magic here!";
		
		// insert content into database
		$q = "UPDATE `webContent` SET `content` = '$content' WHERE `contentID` = $intCid LIMIT 1 ;";
		$dbConn->runQuery($q);
		
		if ($dbConn->getError()!='') return 'noCheck';
		
		// log content into db's cyclic queue
		$q = "INSERT INTO `webConHistory` (`count`,`mod`,`contentID`,`content`) (SELECT ( coalesce(max(`count`), -1) + 1), (( coalesce(max(`count`), -1) + 1) % ".self::$NUM_OF_HISTORY."), $intCid, '$content' FROM `webConHistory` WHERE `contentID` = $intCid) ON DUPLICATE KEY UPDATE count = values(`count`), content = values(`content`);";
		$dbConn->runQuery($q);
		
		return ($dbConn->getError()=='')?'check':'noCheck';
	}

	function addContent($vfsid, $dest, $blockID) {
		$dbConn = new mysqlClass();
		$error = json_encode(array('check' => 'noCheck', 'html' => ''));
		$dest = $dbConn->clean($dest); $intVfsID = (int)$vfsid; $intBlockID = (int)$blockID;
		if (!is_int($intVfsID) || !is_int($intBlockID)) return "No black magic here!";
		
		// start select on input data
		$q = "SELECT v.`orders`+1 AS nextOrder, v.`locID`, b.`editer`, b.`initContent` FROM `vWebCon` as v, `webBlock` as b WHERE v.`locName`='".$dest."' AND v.`vfsID`='".$intVfsID."' AND b.`blockID`='".$intBlockID."' ORDER BY v.`orders` DESC LIMIT 1";
		$toValData = $dbConn->runQuery($q);
		if (mysql_num_rows($toValData) == 0 ) { // new query here that pulls same info, but with orders = 1
			$qf = "SELECT 1 AS nextOrder, l.`locID`, b.`editer`, b.`initContent` FROM `webLocations` as l, `webBlock` as b WHERE l.`locName`='".$dest."' AND b.`blockID`='".$intBlockID."' LIMIT 1";
			$toVal = mysql_fetch_assoc($dbConn->runQuery($qf));
		} else {
			$toVal = mysql_fetch_assoc($toValData);
		}
		if ($dbConn->getError()!='') return $error;
		
		// insert data to database
		$q1 = "INSERT INTO `webContent` (`vfsID`,`blockID`,`content`,`orders`,`location`) VALUES ('".$intVfsID."',  '".$intBlockID."',  '".$toVal['initContent']."',  '".$toVal['nextOrder']."',  '".$toVal['locID']."');";
		$dbConn->runQuery($q1);
		
		$item = mysql_fetch_assoc($dbConn->runQuery("SELECT * FROM `vWebCon` WHERE `contentID` = last_insert_id()"));
		if ($dbConn->getError()!='') return $error;
		
		// compile editer template
		$smarty = new SmartyConfig();
		$tpl = $smarty->createTemplate($toVal['editer']);
		$tpl->assign('item', $item);
		
		// db selection for scripts that arent already on curret page
		
		return json_encode(array('check' => 'check', 'html' => $tpl->fetch())); // might have to convert to json, loading scripts for different editers
	}
	
	function updateOrder($data) {
		$dbConn = new mysqlClass();
		
		foreach ($data as $value) {
			$q = "SELECT locID FROM `webLocations` WHERE `locName`='".$value['dest']."'";
			$loc = mysql_fetch_assoc($dbConn->runQuery($q));
			
			$q1 = "UPDATE `webContent` SET `orders` =  '".$value['ord']."', `location` = '".$loc['locID']."' WHERE `contentID` =".$value['id']." LIMIT 1 ;";
			$dbConn->runQuery($q1);
		}
		
		return ($dbConn->getError()=='')?'check':'noCheck';
	}
	
	function removeContent($remID) {
		$intRemID = (int)$remID;
		if (!is_int($intRemID)) return "No black magic here!";
		
		$dbConn = new mysqlClass();
		
		$q = "DELETE FROM `webContent` WHERE `contentID`=".$intRemID." LIMIT 1";
		$dbConn->runQuery($q);
		
		if ($dbConn->getError()!='') return 'noCheck';
		
		// the following will be replaced with on delete cascate table relation
		$q = "DELETE FROM `webConHistory` WHERE `contentID`=$intRemID LIMIT ".self::$NUM_OF_HISTORY;
		$dbConn->runQuery($q);
		
		return ($dbConn->getError()=='')?'check':'noCheck';
	}
	
}
