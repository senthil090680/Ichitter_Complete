<?php
class Marked {
	
	function __construct() {
		
	}
	
	function insertMarked($post_id, $user_id, $marked_on, $is_active, $is_archived) {
		
		$query = "INSERT INTO tbl_marked (post_id, user_id, marked_on, is_active, is_archived)
				VALUES ('$post_id', '$user_id', '$marked_on', $is_active, $is_archived)";
		
		$result = mysql_query($query);
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
			$condition .= " WHERE user_id = '$user_id' ";
		}
		if($post_id != null) {
			if($condition != "") {
				$condition .= " AND post_id = '$post_id' ";
			}
			else {
				$condition .= " WHERE post_id = '$post_id' ";
			}
		}
		
		$query = " SELECT 	
					mark_id, 
					post_id, 
					user_id, 
					marked_on, 
					is_active, 
					is_archived
	 
					FROM 
						tbl_marked $condition ";
		
		$result = mysql_query($query);
		return $result; 
	
	}
	
	function deleteMarked($mark_id) {
		$query = " DELETE FROM tbl_marked WHERE mark_id = '$mark_id' ";
		
		$result = mysql_query($query);
		return $result;
	}
	
	function __destruct() {
	
	}
}
?>