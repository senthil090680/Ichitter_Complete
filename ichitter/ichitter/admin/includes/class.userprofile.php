<?php
class userProfile {
	
	private $QUERY;
	
	function __construct() {
		$this->QUERY = "";
	}
	
	function getAllUserDetails () {
		$this->QUERY = " SELECT 
							tup.user_id,
							CONCAT_WS(' ', tup.first_Name, tup.last_Name) AS username,
							tup.email,
							CASE WHEN tup.gender = 'm' THEN 'Male' ELSE 'Female' END AS gender,
							tup.last_loggedin AS logintime,
							tup.loggedout AS logouttime,
							tup.registered_on,
							CASE WHEN tup.login_flag = 0 THEN 'Active' ELSE 'Inactive' END AS status,
							tup.log_duration

						FROM 
							tbl_user_profile AS tup ORDER BY tup.user_id DESC ";
		
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	function changeUserStatus ($userid='0', $status = '0') {
		$this->QUERY = " UPDATE tbl_user_profile 
						SET
							login_flag = '$status'
						WHERE
							user_id = '$userid' ";
		mysql_query($this->QUERY);
		return $this->getUserDetailsById($userid);
	}
	
	function getUserDetailsById($userid='0') {
		$this->QUERY = " SELECT 
							tup.user_id,
							CONCAT_WS(' ', tup.first_Name, tup.last_Name) AS username,
							tup.email,
							CASE WHEN tup.gender = 'm' THEN 'Male' ELSE 'Female' END AS gender,
							tup.last_loggedin AS logintime,
							tup.loggedout AS logouttime,
							CASE WHEN tup.login_flag = 0 THEN 'Active' ELSE 'Inactive' END AS status,
							tup.registered_on,
							tup.log_duration
						FROM 
							tbl_user_profile AS tup ORDER BY tup.user_id DESC ";
		
		$result = mysql_query($this->QUERY);
		return mysql_fetch_array($result);
	}
}
?>