<?php
class authenticate {

	var $LOGIN_ID;
	var $ROLE_ID;
	var $USERNAME;
	var $PASSWORD;
	var $LAST_LOGGEDIN;
	var $QUERY;

	function __construct() {
		$this->LOGIN_ID = "";
		$this->ROLE_ID = "";
		$this->USERNAME = "";
		$this->PASSWORD = "";
		$this->LAST_LOGGEDIN = "";
		$this->QUERY = "";
	}

	function validate_user($username, $password) {
		$allow = false;
		$this->QUERY = "SELECT 
                            login_id, 
                            role_id,
                            user_name, 
                            DATE_FORMAT(last_loggedin, '%d-%m-%Y %l:%i:%s') AS last_loggedin 
                        FROM " . LOGIN . " 
                        WHERE user_name LIKE '" . $username . "' AND password LIKE '" . $password . "'";
		$res_sql = mysql_query($this->QUERY);
		$row = mysql_fetch_array($res_sql);
		if (mysql_num_rows($res_sql) == 1) {
			$this->LOGIN_ID = $row["login_id"];
			$this->ROLE_ID = $row["role_id"];
			$this->USERNAME = $row["user_name"];
			$this->LAST_LOGGEDIN = $row["last_loggedin"];
			
			$this->QUERY = "UPDATE " . LOGIN . " SET last_loggedin = '" . date("Y-m-d H:i:s") . "' WHERE login_id = '" . $row["login_id"] . "'";
			$res_sql1 = mysql_query($this->QUERY);
			$allow = true;
		}

		return $allow;
	}

	function check_old_password($username, $password) {
		$allow = false;
		$retpassword = "";
		$this->QUERY = "SELECT password FROM " . LOGIN . " WHERE user_name LIKE '" . $username . "'";
		$res_sql = mysql_query($this->QUERY);
		$row = mysql_fetch_array($res_sql);
		if (mysql_num_rows($res_sql) == 1) {
			$retpassword = $row["password"];
			$allow = true;
		}

		return $retpassword;
	}

	function update_password($username, $password) {
		$this->QUERY = "UPDATE " . LOGIN . " SET password='" . $password . "' WHERE user_name = '" . $username . "'";
		$res_sql = mysql_query($this->QUERY);
		$allow = true;
		return $allow;
	}
}
?>