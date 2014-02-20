<?php
class Discussion {
	
	private $GENERIC;
	var $ARRAY;
	var $TreeArray;
	private $QUERY;
	private $LOG;
	
	public function __construct() {
		$this->GENERIC = new commonGeneric();
		$this->ARRAY = array();
		$this->QUERY = "";
		$this->LOG = new Logging();
	}
	
	public function addNewDiscussion($topicid=null, $subtopicid=null, $postid=null, $userid=null, $fordiscussion=null, $content=null ) {
		$posted_on = date("Y-m-d H:i:s");
		$this->incDiscussionTotal($postid);
		$this->QUERY = " INSERT INTO " . DISCUSSION . " ( 
						user_id, 
						post_id, 
						topic_id, 
						sub_topic_id, 
						for_discussion_id, 
						discussion_content, 
						posted_on, 
						is_archived, 
						is_active
					) VALUES (
						'$userid', 
						'$postid', 
						'$topicid', 
						'$subtopicid', 
						'$fordiscussion', 
						'$content', 
						'$posted_on', 
						0, 
						0 )";
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	function getLastInsertedDiscussion() {
		$id = mysql_insert_id();
		$this->QUERY = " SELECT 
						dsn.discussion_id,
						dsn.user_id,
						dsn.post_id,
						dsn.topic_id,
						dsn.sub_topic_id,
						dsn.for_discussion_id,
						dsn.discussion_content,
						dsn.posted_on,
						DATE_FORMAT(dsn.posted_on, '%M %d, %Y at %l:%i %p') as posted_date, 
						usp.first_Name,
						usp.last_Name,
						CONCAT_WS(' ', usp.first_Name, usp.last_Name) AS uname,
						(SELECT 
								CONCAT_WS('$', tup.gender, tup.profile_image,tig.igallery_name, ti.image_name)
							FROM tbl_user_profile AS tup 
								LEFT JOIN tbl_images AS ti ON (ti.image_id = tup.profile_image)
								LEFT JOIN tbl_igallery AS tig ON (tig.igallery_id = ti.igallery_id)
							WHERE tup.user_id = dsn.user_id) AS image
				FROM 
					 " . DISCUSSION . " AS dsn LEFT JOIN tbl_user_profile AS usp ON (dsn.user_id = usp.user_id)
				WHERE 
					1=1 AND dsn.discussion_id = $id";
		
		$res = mysql_query($this->QUERY);
		$data = mysql_fetch_assoc($res); 
		$fordiscussion = $data['for_discussion_id'];
		if($fordiscussion != 0) {
			$this->incReplyCount($fordiscussion);
		}
		return $data;
	}
	
	function incDiscussionTotal($post_id=null) {
		$this->QUERY = "UPDATE " . POSTINGS . " SET disc_total = (disc_total + 1) WHERE posting_id = " . $post_id;
		mysql_query($this->QUERY);
	}
	
	private function incReplyCount($disc_id=null) {
		$this->QUERY = "UPDATE " . DISCUSSION . " SET reply_count = (reply_count + 1) WHERE discussion_id = " . $disc_id;
		mysql_query($this->QUERY);
	}
	
	function decReplyCount($disc_id=null) {
		$this->QUERY = "SELECT reply_count FROM tbl_discussion WHERE discussion_id = $disc_id";
		$sqlResult = mysql_query($this->QUERY);
		$num_rows = mysql_num_rows($sqlResult); 
		$num_rows >= 1 ? true : false;
		if($num_rows) {
			$this->QUERY = " UPDATE " . DISCUSSION . " SET reply_count = (reply_count - 1) WHERE discussion_id = " . $disc_id;
			mysql_query($this->QUERY);
		}
	}
	
	public function getDiscussionCount($topicid=null, $subtopicid=null, $postid=null, $fordiscussion=null) {
		$condition = "";
		
		if(($topicid != null) && ($topicid != "")) {
			$condition .= " AND topic_id = $topicid";
		}
		if(($subtopicid != null) && ($subtopicid != "")) {
			$condition .= " AND sub_topic_id = $subtopicid";
		}
		if(($postid != null) && ($postid != "")) {
			$condition .= " AND post_id = $postid";
		}
		if(($fordiscussion != null) && ($fordiscussion != "")) {
			$condition .= " AND for_discussion_id = $fordiscussion";
		}
		
		$this->QUERY = "SELECT 
					count(*) as cnt
				FROM 
					" . DISCUSSION . "  
				WHERE 1=1  $condition";
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	public function getDiscussions($topicid=null, $subtopicid=null, $postid=null, $fordiscussion=null) {
		$condition = "";
		
		if(($topicid != null) && ($topicid != "")) {
			$condition .= " AND topic_id = $topicid";
		}
		if(($subtopicid != null) && ($subtopicid != "")) {
			$condition .= " AND sub_topic_id = $subtopicid";
		}
		if(($postid != null) && ($postid != "")) {
			$condition .= " AND post_id = $postid";
		}
		if(($fordiscussion != null) && ($fordiscussion != "")) {
			$condition .= " AND for_discussion_id = $fordiscussion";
		}
		$this->QUERY = " SELECT 
						dsn.discussion_id,
						dsn.user_id,
						dsn.post_id,
						dsn.topic_id,
						dsn.sub_topic_id,
						dsn.for_discussion_id,
						dsn.discussion_content,
						dsn.posted_on,
						DATE_FORMAT(dsn.posted_on, '%M %d, %Y at %l:%i %p') as posted_date,  
						usp.first_Name,
						usp.last_Name
				FROM 
					 " . DISCUSSION . " AS dsn LEFT JOIN tbl_user_profile AS usp ON (dsn.user_id = usp.user_id)
				WHERE 
					1=1  $condition ";
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	function discussionList($postid = null, $fordiscussion = null, $sort='0'){ 
        $output = ''; 
		$condition = "";
		if(($postid != null) && ($postid != "")) {
			$condition .= " AND post_id = $postid";
		}
		if(($fordiscussion != null) && ($fordiscussion != "")) {
			$condition .= " AND for_discussion_id = $fordiscussion";
		}
		$orderby = "";
		if($sort == '0') {
			$orderby .= " ORDER BY posted_on DESC ";
		}elseif($sort == '1') {
			$orderby .= " ORDER BY posted_on ASC ";
		}
		
		$this->QUERY = " SELECT 
							dsn.discussion_id,
							dsn.user_id,
							dsn.post_id,
							dsn.topic_id,
							dsn.sub_topic_id,
							dsn.for_discussion_id,
							dsn.discussion_content,
							dsn.posted_on,
							DATE_FORMAT(dsn.posted_on, '%M %d, %Y at %l:%i %p') as posted_date, 
							usp.first_Name,
							usp.last_Name,
							CONCAT(usp.first_Name, ' ', usp.last_Name) AS fullname,
							(SELECT 
								CONCAT_WS('$', tup.gender, tup.profile_image,tig.igallery_name, ti.image_name)
							FROM tbl_user_profile AS tup 
								LEFT JOIN tbl_images AS ti ON (ti.image_id = tup.profile_image)
								LEFT JOIN tbl_igallery AS tig ON (tig.igallery_id = ti.igallery_id)
							WHERE tup.user_id = dsn.user_id) AS image
					FROM 
						" . DISCUSSION . " AS dsn 
						LEFT JOIN tbl_user_profile AS usp ON (dsn.user_id = usp.user_id)
					WHERE 
						1=1 $condition $orderby ";
		$sqlResult = mysql_query($this->QUERY);
		$num_rows = mysql_num_rows($sqlResult);  
        
        if ($num_rows > 0) {  
			while($row = mysql_fetch_assoc($sqlResult)) { 
				$output .= $row['discussion_id'] . "<br />"; 
				$this->ARRAY[] = array("id" => $row['discussion_id'], "parentid" => "$fordiscussion", "rec" => $row);
                if ($this->has_sub($row['discussion_id'])) {
					$output .= $this->discussionList($postid, $row['discussion_id'], 1);
				}
            }  
        }  
         
        return $output; 
    } 
     
    function has_sub($fordiscussion){ 
		$condition = "";
		if(($fordiscussion != null) && ($fordiscussion != "")) {
			$condition .= " AND for_discussion_id = $fordiscussion";
		}
		
		$this->QUERY = " SELECT 
						dsn.discussion_id,
						dsn.user_id,
						dsn.post_id,
						dsn.topic_id,
						dsn.sub_topic_id,
						dsn.for_discussion_id,
						dsn.discussion_content,
						dsn.posted_on,
						DATE_FORMAT(dsn.posted_on, '%M %d, %Y at %l:%i %p') as posted_date, 
						usp.first_Name,
						usp.last_Name
				FROM 
					 " . DISCUSSION . " AS dsn 
					LEFT JOIN tbl_user_profile AS usp ON (dsn.user_id = usp.user_id)
				WHERE 
					1=1 $condition  ORDER BY dsn.posted_on ASC ";
		
        $sqlResult = mysql_query($this->QUERY);  
        $num_rows = mysql_num_rows($sqlResult);  
        return $num_rows >= 1 ? true : false; 
    }
	
	function getProfileImage($userid=null) {
		$this->QUERY = "SELECT 
							CONCAT_WS('$', tup.profile_image,tig.igallery_name, ti.image_name) AS image
						FROM tbl_user_profile AS tup 
							LEFT JOIN tbl_images AS ti ON (ti.image_id = tup.profile_image)
							LEFT JOIN tbl_igallery AS tig ON (tig.igallery_id = ti.igallery_id)
						WHERE tup.user_id = $userid";
		$sqlResult = mysql_query($this->QUERY); 
        $num_rows = mysql_num_rows($sqlResult);
		
        if($num_rows >= 1) {
			
		}
	}
	
	function getIWasRespondedTo($postid = null, $fordiscussion = null, $sort='0'){ 
        $output = ''; 
		$condition = "";
		if(($postid != null) && ($postid != "")) {
			$condition .= " AND post_id = $postid";
		}
		if(($fordiscussion != null) && ($fordiscussion != "")) {
			$condition .= " AND for_discussion_id = $fordiscussion";
		}
		
		$this->QUERY = " SELECT 
						dsn.discussion_id,
						dsn.user_id,
						dsn.post_id,
						dsn.topic_id,
						dsn.sub_topic_id,
						dsn.for_discussion_id,
						dsn.discussion_content,
						dsn.posted_on,
						DATE_FORMAT(dsn.posted_on, '%M %d, %Y at %l:%i %p') as posted_date, 
						usp.first_Name,
						usp.last_Name,
						CONCAT(usp.first_Name, ' ', usp.last_Name) AS fullname 
						
				FROM 
					 " . DISCUSSION . " AS dsn LEFT JOIN tbl_user_profile AS usp ON (dsn.user_id = usp.user_id)
				WHERE 
					1=1  $condition $orderby ";
		
        $sqlResult = mysql_query($this->QUERY);  
		$num_rows = mysql_num_rows($sqlResult);  
        
        if ($num_rows > 0) {  
			while($row = mysql_fetch_assoc($sqlResult)) { 
				$output .= $row['discussion_id'] . "<br />"; 
				$this->ARRAY[] = array("id" => $row['discussion_id'], "parentid" => "$fordiscussion", "rec" => $row);
                if ($this->has_sub($row['discussion_id'])) {
					$output .= $this->discussionList($postid, $row['discussion_id']);
				}
            }  
        }  
         
        return $output; 
    }
	
	private function isDiscussionOpened($user_id=null, $disc_id=null) {
		$this->QUERY = "SELECT 	disc_read_id, discussion_id, user_id, opened_on
						FROM " . DISCUSSION_READ . " WHERE discussion_id = '$disc_id' AND user_id = '$user_id'";
		$sqlResult = mysql_query($this->QUERY);  
        $num_rows = mysql_num_rows($sqlResult);  
        return $num_rows >= 1 ? true : false;
	}
	
	function setDiscussionViewed($user_id=null, $disc_id=null) {
		$opened_on = date("Y-m-d H:i:s");
		if(!$this->isDiscussionOpened($user_id, $disc_id)) {
			$this->QUERY = "INSERT INTO " . DISCUSSION_READ . " (discussion_id, user_id, opened_on)
							VALUES('$disc_id', '$user_id', '$opened_on') ";
		}else {
			$this->QUERY = "UPDATE " . DISCUSSION_READ . " 
							SET	opened_on = '$opened_on'
							WHERE discussion_id = '$disc_id' AND user_id = '$user_id'";
		}
		$res = mysql_query($this->QUERY);
		if($res) {
			return 1;
		}else{
			return 0;
		}
	}
	
	function deleteDiscussions($post_id='0') {
		$result = false;
		$disc_read = "DELETE FROM " . DISCUSSION_READ . " 
						WHERE
					discussion_id IN (SELECT 
										discussion_id 
									 FROM " . DISCUSSION . " 
									 WHERE post_id = $post_id)";
		$res = mysql_query($disc_read);
		if($res){
			$this->QUERY = "DELETE FROM " . DISCUSSION . " WHERE post_id = $post_id";
			$result = mysql_query($this->QUERY);
		}
		
		return $result;
	}
	
	function get_iChitterDiscussionsByUserGroups($userid='0', $limit='25') {
		$this->QUERY = "SELECT 
							T3.discussion_id,
							T3.user_id,
							T3.discussion_content,
							CASE WHEN LENGTH(T3.discussion_content) > 45 THEN CONCAT(substr(T3.discussion_content, 1, 45), '...' ) ELSE T3.discussion_content END as content,
							DATE_FORMAT(T3.posted_on, '%M %d, %Y at %l:%i %p') as posted_date
						FROM tbl_discussion AS T3
						WHERE T3.user_id IN (SELECT 
											DISTINCT T2.user_id_joined 
										FROM tbl_group_members AS T2
										WHERE T2.group_id IN (SELECT 
																DISTINCT T1.group_id 
														FROM tbl_group_members AS T1
														WHERE T1.user_id_joined=$userid)) ORDER BY T3.posted_on DESC LIMIT $limit ";
	
		$res = mysql_query($this->QUERY);
		return $res;
	}
	
	public function __destruct() {
		
	}
}
?>