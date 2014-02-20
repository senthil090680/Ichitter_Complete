<?php
class Marked {
	//var $LOG;
	private $Query;
	
	function __construct() {
		//$this->LOG = new Logging();
		$this->Query = "";
	}
	
	function insertMarked($post_id, $sub_topic_id, $user_id, $marked_on, $is_active, $is_archived) {
		$arrCnt = 0;
		$arrCnt = count($this->isMarked($post_id, $user_id));
		$result = true;
		if($arrCnt > 0) {
			$this->Query = "INSERT INTO tbl_marked (post_id, sub_topic_id, user_id, marked_on, is_active, is_archived)
					VALUES ('$post_id', '$sub_topic_id', '$user_id', '$marked_on', $is_active, $is_archived)";
			$result = mysql_query($this->Query);
		}
		return $result;
	}
		
	
	function updateMarked($post_id, $user_id, $marked_on, $is_active, $is_archived) {
		$query = "UPDATE tbl_marked 
				SET
					post_id = '$post_id' , 
					user_id = '$user_id' , 
					marked_on = '$marked_on' , 
					is_active = $is_active , 
					is_archived = $is_archived
				WHERE
					mark_id = '$mark_id' ";
		$result = mysql_query($query);
		return $result;
	}
	
	function selectMarkedByUserID($user_id = null, $post_id = null ) {
		$condition = "";
		
		if($user_id != null) {
			$condition .= "  AND user_id = '$user_id' ";
		}
		if($post_id != null) {
			$condition .= " AND post_id = '$post_id' ";
		}
		
		$query = " SELECT 	
						mark_id, 
						post_id, 
						user_id, 
						sub_topic_id,
						marked_on, 
						is_active, 
						is_archived
					FROM tbl_marked WHERE 1=1  $condition ";
		$arr = array();
		$result = mysql_query($query);
		$arr = mysql_fetch_assoc($result);
		//$this->LOG->lwrite(count($arr));
		return $arr; 
	
	}
	
	function deleteMarked($mark_id) {
		
		$query = " DELETE FROM tbl_marked WHERE mark_id = '$mark_id' $condition ";
		$result = mysql_query($query);
		return $result;
	}
	
	function delMarkedByUser($user_id = null, $sub_topic_id = null, $post_id = null) {
		$condition = " WHERE 1=1 ";
		if(($user_id != null) || ($user_id != "")) {
			$condition .= " AND user_id = " . $user_id;
		}
		
		if(($sub_topic_id != null) || ($sub_topic_id != "")) {
			$condition .= " AND  sub_topic_id = " . $sub_topic_id;
		}
		
		if(($post_id != null) || ($post_id != "")) {
			$condition .= " AND  post_id = " . $post_id;
		}
		
		$query = " DELETE FROM tbl_marked $condition ";
		//$this->LOG->lwrite("del" . $query);
		$result = mysql_query($query);
		return $result;
	}
	
	function isMarked($post_id = null, $user_id = null) {
		
		$condition = " WHERE 1=1 ";
		if(($user_id != null) || ($user_id != "")) {
			$condition .= " AND user_id = " . $user_id;
		}
		
		if(($post_id != null) || ($post_id != "")) {
			$condition .= " AND  post_id = " . $post_id;
		}
		
		$query = " SELECT mark_id, sub_topic_id, post_id, user_id 
					FROM  tbl_marked $condition ";
		$arr = array();
		$result = mysql_query($query);
		$arr = mysql_fetch_assoc($result);
		return $arr; 
	}
	
	function __destruct() {
		
	}
}
?>