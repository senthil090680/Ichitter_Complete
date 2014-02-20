<?php
class postings {
	private $QUERY;
	
	function _construct() {
		$this->QUERY = "";
	}
	
	function listPostings($topicid=null, $subtopicid=null) {
		$condition = " WHERE 1=1 ";
		if(isset($topicid)) {
			$condition .= " AND post.topic_id = $topicid ";
		}
		if(isset($subtopicid)) {
			$condition .= " AND post.sub_topic_id = $subtopicid ";
		}
		
		$this->QUERY = " SELECT 
							post.posting_id, 
							tpc.title AS topic,
							stpc.title AS subtopic, 
							post.title, 
							CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(substr(post.title, 1, 23) , '...' ) ELSE post.title END as posttitle,
							post.post_content,
							CASE WHEN LENGTH(post.post_content) > 27 THEN CONCAT(substr(post.post_content, 1, 27) , '...' ) ELSE post.post_content END as content,
							post.graphic_type, 
							post.image_id, 
							post.video_id, 
							post.posted_on, 
							CAST(post.is_active AS UNSIGNED INT) AS is_active,
							CAST(post.is_archived AS UNSIGNED INT) AS is_archived,
							img.image_name,
							igl.igallery_name,
							vdo.video_name,
							vgl.vgallery_name
						FROM tbl_posting  AS post LEFT JOIN tbl_images AS img ON (post.image_id = img.image_id)
							LEFT JOIN  tbl_igallery AS igl ON (img.igallery_id = igl.igallery_id)
							LEFT JOIN tbl_videos AS vdo ON (post.video_id = vdo.video_id)
							LEFT JOIN tbl_vgallery AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
							LEFT JOIN tbl_topics AS tpc ON (tpc.topics_id = post.topic_id)
							LEFT JOIN tbl_sub_topics AS stpc ON (stpc.sub_topic_id = post.sub_topic_id)
							 $condition ORDER BY post.posted_on DESC ";
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	function getPostingsByPostId($postingid=null) {
		$condition = " WHERE 1=1 ";
		if(isset($postingid)) {
			$condition .= " AND post.posting_id = $postingid ";
		}
		$this->QUERY = " SELECT 
							post.posting_id, 
							tpc.title AS topic,
							stpc.title AS subtopic, 
							post.title, 
							CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(substr(post.title, 1, 23) , '...' ) ELSE post.title END as posttitle,
							post.post_content,
							CASE WHEN LENGTH(post.post_content) > 27 THEN CONCAT(substr(post.post_content, 1, 27) , '...' ) ELSE post.post_content END as content,
							post.graphic_type, 
							post.image_id, 
							post.video_id, 
							post.posted_on, 
							CAST(post.is_active AS UNSIGNED INT) AS is_active,
							CAST(post.is_archived AS UNSIGNED INT) AS is_archived,
							img.image_name,
							igl.igallery_name,
							vdo.video_name,
							vgl.vgallery_name
						FROM tbl_posting  AS post LEFT JOIN tbl_images AS img ON (post.image_id = img.image_id)
							LEFT JOIN  tbl_igallery AS igl ON (img.igallery_id = igl.igallery_id)
							LEFT JOIN tbl_videos AS vdo ON (post.video_id = vdo.video_id)
							LEFT JOIN tbl_vgallery AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
							LEFT JOIN tbl_topics AS tpc ON (tpc.topics_id = post.topic_id)
							LEFT JOIN tbl_sub_topics AS stpc ON (stpc.sub_topic_id = post.sub_topic_id)
							 $condition ORDER BY post.posted_on DESC ";
		$result = mysql_query($this->QUERY);
		return mysql_fetch_array($result);
	}
}
?>
