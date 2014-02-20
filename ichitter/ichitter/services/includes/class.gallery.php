<?php
// Contains images and videos related functions
class Gallery {
	
	var $LOG;
	
	function __construct() {
		$this->LOG = new Logging();
	}
	
	function getImagesByUser($user_id) {
		$query = " SELECT  
					image_id, 
					user_id, 
					image_name, 
					date_uploaded, 
					date_last_updated, 
					image_description, 
					is_active, 
					is_archieved
				FROM
					tbl_images 
				WHERE user_id = $user_id ";
		
		$result = mysql_query($query);
		return $result;
	}
	
	function getVideosByUser($user_id) {
		$query = " SELECT 	
						video_id, 
						user_id, 
						video_name, 
						date_uploaded, 
						date_last_updated, 
						video_description, 
						is_active, 
						is_archieved
					FROM 
						tbl_videos  
					WHERE user_id = $user_id ";
		$this->LOG->lwrite($query);
		$result = mysql_query($query);
		return $result;
	}
	
	
	
	
	function __destruct() {
		
	}
}
?>