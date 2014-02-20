<?php
error_reporting(0);
require_once "includes/dbobj.php";
require_once "includes/json.php";

class bflogout_service {

	private $QUERY;
	private $ObjJSON;

	function __construct() {
		$this->ObjJSON = new Services_JSON();
		$this->QUERY = "";
	}
	
	function getlog_logouttime($user_id = '0') {
		$this->QUERY = "SELECT 
							last_loggedin AS starttime,
							loggedout AS endtime,
							log_duration AS duration
						FROM tbl_user_profile
						WHERE `user_id` = '$user_id'";
		$RS = mysql_query($this->QUERY);
		return mysql_fetch_array($RS);
	}

	function _update_before($user_id) {
		if ($user_id != "") {
			$query = "UPDATE `tbl_user_profile` 
						SET status = 'Offline',
							loggedout = now()
						WHERE `user_id` = '$user_id' ";
			$executequery = mysql_query($query);
			
			$times = $this->getlog_logouttime($user_id);
			$starttime = (isset($times['starttime']))?$times['starttime']:0;
			$endtime = (isset($times['endtime']))?$times['endtime']:0;
			$duration = (isset($times['duration']))?$times['duration']:0;
			$hours = $this->timeBetween($starttime, $endtime);
			
			$duration += $hours;
			
			$this->QUERY = "UPDATE tbl_user_profile 
						SET log_duration = '$duration'
						WHERE user_id = '$user_id' ";
			$exequery = mysql_query($this->QUERY);
			
			//$return['sql'] = $query;
			if ($executequery) {
				$return['response'] = "success";
			} else {
				$return['response'] = "Query Not executed";
			}
		} else {
			$return['response'] = "error";
		}

		return $this->ObjJSON->encode($return);
	}
	
	function timeBetween($start_date, $end_date) {
		$diff = $end_date - $start_date;
		$seconds = 0;
		$hours = 0;
		$minutes = 0;
		if ($diff % 86400 <= 0) {
			$days = $diff / 86400;
		}
		if ($diff % 86400 > 0) {
			$rest = ($diff % 86400);
			$days = ($diff - $rest) / 86400;
			if ($rest % 3600 > 0) {
				$rest1 = ($rest % 3600);
				$hours = ($rest - $rest1) / 3600;
				if ($rest1 % 60 > 0) {
					$rest2 = ($rest1 % 60);
					$minutes = ($rest1 - $rest2) / 60;
					$seconds = $rest2;
				} else {
					$minutes = $rest1 / 60;
				}
			} else {
				$hours = $rest / 3600;
			}
		}
		$hrs = 0;
		if ($days > 0) {
			$hrs = $hrs + ($days * 24);
		} else {
			$days = false;
		}
		if ($hours > 0) {
			$hrs = $hrs + $hours;
		}	
		return $hrs;
	}
}

$user_id = $_POST['user_id'];
$bflogout = $_POST['bflogout'];

$bf_obj = new bflogout_service();
if (isset($bflogout)) {
	echo $updatestatus = $bf_obj->_update_before($user_id);
}
?>