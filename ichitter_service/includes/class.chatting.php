<?php
class chatting {

	private $QUERY;
	private $QUERYTWO;
	private $QUERYTHREE;
	private $QUERYFOUR;
	
	function __construct() {
		$this->QUERY = "";
		$this->QUERYTWO = "";
		$this->QUERYTHREE = "";
		$this->QUERYFOUR = "";
	}
	
	function get_user_name($userid) {
		$this->QUERY = "SELECT first_Name, last_Name FROM tbl_user_profile WHERE user_id='$userid'";
		$userquery = mysql_query($this->QUERY);
		$userrow = mysql_fetch_array($userquery);
		return $userrow;
	}
	
	function updateChatHeartbeat($username, $chatfrom) {
		$this->QUERY  = "UPDATE chat SET recd = 2 
				WHERE chat.to = '" . mysql_real_escape_string($username) . "' 
					AND chat.from = '" . mysql_real_escape_string($chatfrom) . "' 
					AND recd = 0";
		return mysql_query($this->QUERY);
	}

	
	function confirmChatHeartbeat($username, $chatfrom) {
		$this->QUERY = "DELETE FROM chat WHERE sent <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)";
		mysql_query($this->QUERY);
		$this->QUERYTWO = "SELECT * FROM chat 
					WHERE (chat.to = '" . mysql_real_escape_string($username) . "' 
						AND chat.from = '" . mysql_real_escape_string($chatfrom) . "' 
						AND recd = 7) ORDER BY id ASC";
		$RES_SET = mysql_query($this->QUERYTWO);
		
		$this->QUERYTHREE = "UPDATE chat SET recd = 2 
						WHERE chat.to = '" . mysql_real_escape_string($username) . "' 
						AND chat.from = '" . mysql_real_escape_string($chatfrom) . "' and recd = 7";
		mysql_query($this->QUERYTHREE);
		return $RES_SET;
	}
	function chatHeartbeat($username) {
		$this->QUERY = "DELETE FROM chat WHERE sent <= DATE_SUB(NOW(), INTERVAL 60 MINUTE)";
		mysql_query($this->QUERY);
		$this->QUERYTWO = "SELECT * FROM chat 
					WHERE (chat.to = '" . mysql_real_escape_string($username) . "' 
					AND recd = 0) ORDER BY id ASC";
		$res_set = mysql_query($this->QUERYTWO);
		return $res_set;
	}
	
	function sendChat($from, $to, $message) {
		$this->QUERY = "insert into chat (chat.from,chat.to,message,sent,recd) 
			values ('" . mysql_real_escape_string($from) . "', 
				'" . mysql_real_escape_string($to) . "', 
				'" . mysql_real_escape_string($message) . "',NOW(),'0')";
		mysql_query($this->QUERY);
	}

	function busyChat($senderid, $username, $chatbox) {
		$this->QUERY = "update chat set recd = 5 
			WHERE chat.to = '" . mysql_real_escape_string($username) . "' 
				AND chat.from = '" . mysql_real_escape_string($chatbox) . "' 
				AND recd = 0";
		mysql_query($this->QUERY);
		$message = "I am busy";
		$this->QUERY = "INSERT INTO chat (chat.from,chat.to,message,sent) 
			values ('" . mysql_real_escape_string($username) . "', 
				'" . mysql_real_escape_string($senderid) . "', 
					'" . mysql_real_escape_string($message) . "', NOW())";
		mysql_query($this->QUERY);
	}
	
	function beforeChatOpen($username, $chatbox) {
		$this->QUERY = "UPDATE chat SET recd = 7 
			WHERE chat.to = '" . mysql_real_escape_string($username) . "' 
				AND chat.from = '" . mysql_real_escape_string($chatbox) . "' 
				AND recd = 0";
		mysql_query($this->QUERY);
	}
	
	function closeChat($username, $chatbox) {
		$this->QUERY = "update chat set recd = 3 
			WHERE chat.to = '" . mysql_real_escape_string($username) . "' 
				AND chat.from = '" . mysql_real_escape_string($chatbox) . 
				"' AND recd = 0";
		mysql_query($this->QUERY);
	}
}
?>
