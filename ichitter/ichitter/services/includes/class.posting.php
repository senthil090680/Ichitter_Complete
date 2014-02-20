<?php
class postings {
	
	private $GENERIC;
	private $LOG;
	var $sub_topic_id; 
	var $user_id;
	var $post_content; 
	var $graphic_type; 
	var $image_id;
	var $igallery_id; 
	var $video_id; 
	var $vgallery_id; 
	var $posted_on; 
	var $is_active; 
	var $is_archived;
	
	function __construct() {
		$this->GENERIC = new commonGeneric();
		$this->LOG = new Logging();
	}
	
	function getPostingsByID($post_id='', $sub_topic_id='', $user_id='', $is_archived = '0'){
		$Cond_Where = "";
		$select ="SELECT posting_id, 
					sub_topic_id, 
					user_id, 
					title, 
					post_content, 
					graphic_type, 
					image_id, 
					igallery_id, 
					video_id, 
					vgallery_id, 
					posted_on, 
					CAST(is_active AS unsigned int) as is_active,
					CAST(is_archieved AS unsigned int) as is_archieved
				FROM " . POSTINGS . " ";
		
		if($post_id != '') {
			$Cond_Where = " posting_id = " . $post_id;
		}
		
		if ($sub_topic_id != '') {
			if($Cond_Where != "") {
				$Cond_Where = " AND sub_topic_id = " . $sub_topic_id;
			}
			else {
				$Cond_Where = " sub_topic_id = " . $sub_topic_id;
			}
		}
		
		if ($user_id != '') {
			if($Cond_Where != "") {
				$Cond_Where = " AND user_id = " . $user_id;
			}
			else {
				$Cond_Where = " user_id = " . $user_id;
			}
		}
		
		if($is_archived != 'A') {
			$Cond_Where = " AND is_archived = " . $is_archived;
		}
		
		$sql = $select . $Cond_Where; 
		
		$result = mysql_query($sql) or die(mysql_error());

        return $result;
	}
	
	function insertPosting($topic_id, $sub_topic_id, $user_id, $title, $post_content, $graphic_type, 
						$image_id, $igallery_id, $video_id, $vgallery_id, 
						$posted_on, $is_active, $is_archived){
		$sql = "INSERT INTO tbl_posting ( 
				topic_id, sub_topic_id, user_id, title, post_content, graphic_type, 
				image_id, igallery_id, video_id, vgallery_id, 
				posted_on, is_active,is_archived
				) VALUES (
				'$topic_id', '$sub_topic_id', '$user_id', '$title', '$post_content', '$graphic_type', 
				'$image_id', '$igallery_id', '$video_id', '$vgallery_id', 
				'$posted_on', $is_active, $is_archived )";
		
		$this->LOG->lwrite($sql);
		
		$result = mysql_query($sql) or die(mysql_error());
        return $result;
	}
	
	function updatePosting($topic_id, $sub_topic_id, $user_id, $title, $post_content, $graphic_type, 
						$image_id, $igallery_id, $video_id, $vgallery_id, 
						$posted_on, $is_active, $is_archived){
		$sql = "UPDATE " . POSTINGS .  
				" SET 
					topic_id = '$topic_id' , 
					sub_topic_id = '$sub_topic_id' , 
					user_id = '$user_id' ,
					title = '$title',  
					post_content = '$post_content' , 
					graphic_type = '$graphic_type' , 
					image_id = '$image_id' , 
					igallery_id = '$igallery_id' , 
					video_id = '$video_id' , 
					vgallery_id = '$vgallery_id' , 
					posted_on = '$posted_on' , 
					is_active = $is_active , 
					is_archived = $is_archived
				WHERE
					posting_id = '$posting_id'";
		
		$this->LOG->lwrite($sql);
		
		$result = mysql_query($sql) or die(mysql_error());
        return $result;
	}
	
	function deletePosting($post_id) {
		/*$sql = "UPDATE " . POSTINGS . " SET
					 is_archived = '1' 
					WHERE post_id = " . $post_id . " "; */
        $sql    =   "DELETE FROM " . POSTINGS . " WHERE post_id = " . $post_id ;
		$res_sql	=	mysql_query($sql) or die ("INVALID QUERY".mysql_error());
		$allow	=	$res_sql;
		return $allow;
	}
	
	function mark_posts($user_id, $post_ids) {
		//MARKED_POSTS
		$is_active = 0;
		$is_archived = 0;
		$marked_on = date("Y-m-d H:i:s");
		
		foreach ($post_ids as $k => $post_id) {
			
			$sql = "INSERT INTO " . MARKED_POSTS . " (post_id, user_id, marked_on, is_active, is_archived )
				VALUES ('$post_id', '$user_id', '$marked_on', $is_active, $is_archived)";
			$res_sql	=	mysql_query($sql) or die ("INVALID QUERY" . mysql_error());
		}
		
	}
	
	function __destruct() {
		//$this = null;
	}
	
}
?>