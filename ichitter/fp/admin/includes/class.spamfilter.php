<?php
class spamFilter {
	private $QUERY;
	private $DB;
	private $LOG;
	var $SpamWord;
	var $SpamID;
	
	function __construct() {
		global $db, $logs;
		$this->QUERY = "";
		$this->DB = $db;
		$this->LOG = $logs;
		$this->SpamWord = "";
		$this->SpamID = "";
	}
	
	function getSpamWords($spamid='0') {
		$condition = "";
		if(($spamid != "") && ($spamid != '0')) {
			$condition .= " WHERE bw_id = $spamid ";
		}
		$this->QUERY = "SELECT bw_id, bw_word, created_on, updated_on FROM tbl_badwords $condition ORDER BY updated_on DESC ";
		$result = $this->DB->executeQuery($this->QUERY);
		return $result;
	}
	
	function setSpamWords() {
		$this->QUERY = "SELECT bw_id, bw_word, created_on, updated_on FROM tbl_badwords ORDER BY created_on DESC ";
		$result = $this->DB->executeQuery($this->QUERY);
		return $result;
	}
	
	function addSpamWord() {
		$this->QUERY = "INSERT INTO tbl_badwords 
							(bw_word, created_on, updated_on)
						VALUES('" . mysql_real_escape_string($this->SpamWord) . "', now(), now())";
		$result = $this->DB->executeQuery($this->QUERY);
		return $result;
	}
	
	function updateSpamWord() {
		$this->QUERY = "UPDATE tbl_badwords 
						SET
							bw_word = '" . mysql_real_escape_string($this->SpamWord) . "' , 
							updated_on = now()
						WHERE
							bw_id = '" . $this->SpamID . "'";
		$result = $this->DB->executeQuery($this->QUERY);
		return $result;
	}
	
	function delSpamWord() {
		$this->QUERY = "DELETE FROM tbl_badwords WHERE bw_id = '" . $this->SpamID . "'";
		$result = $this->DB->executeQuery($this->QUERY);
		return $result;
	}
	
	function findSpamWord() {
		$return = 0;
		$this->QUERY = "SELECT bw_id, bw_word, created_on, updated_on FROM tbl_badwords WHERE bw_word = '" . $this->SpamWord . "'";
		$result = $this->DB->executeQuery($this->QUERY);
		$rowCnt = mysql_num_rows($result);
		if($rowCnt > 0) {
			$return = 1;
		}
		return $return;
	}
}
?>
