<?php
class postings {

	private $GENERIC;
	private $Query;
	private $badwords;
	private $OBJDiscussion;
	private $log;
	
	function postings() {
		$this->GENERIC = new commonGeneric();
		$this->badwords = array();
		$this->OBJDiscussion = new Discussion();
		//$this->log = new Logging();
	}
	

	function getPostingsByID($post_id='', $topic_id='', $sub_topic_id='', $user_id='', $Order='ASC', $limit='', $is_archived = 'A', $is_marked = false, $foruser="") {
		$condition = " WHERE 1=1 ";
		$sq_cond = " WHERE 1=1 ";
		$mrk = "";
		if($is_marked == true || $user_id != '') {
			$mrk .= "(SELECT mark_id FROM " . MARKED_POSTS . " WHERE post_id=post.posting_id AND user_id = $user_id) AS mark_id,
			(SELECT user_id FROM " . MARKED_POSTS . " WHERE post_id=post.posting_id AND user_id = $user_id) AS mrkuser,";
		} else {
			$mrk .= "(SELECT mark_id FROM " . MARKED_POSTS . " WHERE post_id=post.posting_id AND user_id = post.user_id) AS mark_id,
			(SELECT user_id FROM " . MARKED_POSTS . " WHERE post_id=post.posting_id AND user_id = post.user_id) AS mrkuser,";
		}
		
		$select = "SELECT 
			post.posting_id, 
			tpc.title AS topic,
			stpc.title AS subtopic, 
			post.topic_id, 
			post.sub_topic_id, 
			post.user_id, 
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
			vgl.vgallery_name,
			 $mrk 
			(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND for_discussion_id=0) AS counts
		    FROM " . POSTINGS . "  AS post LEFT JOIN " . IMAGES . " AS img ON (post.image_id = img.image_id)
			LEFT JOIN  " . IGALLERY . " AS igl ON (img.igallery_id = igl.igallery_id)
			LEFT JOIN " . VIDEOS . " AS vdo ON (post.video_id = vdo.video_id)
			LEFT JOIN " . VGALLERY . " AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
			LEFT JOIN " . TOPICS . " AS tpc ON (tpc.topics_id = post.topic_id)
			LEFT JOIN " . SUB_TOPICS . " AS stpc ON (stpc.sub_topic_id = post.sub_topic_id) ";

		if ($post_id != '') {
			$condition .= " AND post.posting_id = " . $post_id;
		}

		if ($sub_topic_id != '') {
			$condition .= " AND post.sub_topic_id = " . $sub_topic_id;
			$sq_cond .= " AND mk.sub_topic_id = " . $sub_topic_id;
		}

		if ($user_id != '') {
			//if(!$is_marked){
				//$condition .= " AND post.user_id = " . $user_id;
			//}
			$sq_cond .= " AND mk.user_id = " . $user_id;
		}
		
		if($foruser){
			$condition .= " AND post.user_id = " . $foruser;
		}
		
		if($is_marked) {
			$condition .= " AND post.posting_id IN ( SELECT mk.post_id FROM " . MARKED_POSTS . " as mk $sq_cond )";
		}
		
		if ($topic_id != '') {
			$condition .= " AND post.topic_id = " . $topic_id;
		}
		
		$OrderBy = " ORDER BY posted_on $Order ";
		
		$RecLimit = "";
		if ($limit != '') {
			$RecLimit = " LIMIT $limit ";
		}
		
		$this->Query = $select . $condition . $OrderBy . $RecLimit;
		//$this->log->lwrite($this->Query);
		$result = mysql_query($this->Query) or die(mysql_error());
		return $result;
	}

	function insNewPosting($topic_id, $sub_topic_id, $user_id, $title, $post_content, $graphic_type, $image_id, $igallery_id, $video_id, $vgallery_id, $posted_on, $is_active, $is_archived) {
		$title = mysql_real_escape_string($title);
		$post_content = mysql_real_escape_string($post_content);
		
		$this->Query = "INSERT INTO tbl_posting ( 
                        topic_id, sub_topic_id, user_id, title, post_content, graphic_type, 
                        image_id, igallery_id, video_id, vgallery_id, 
                        posted_on, is_active,is_archived
                        ) VALUES (
                        '$topic_id', '$sub_topic_id', '$user_id', '$title', '$post_content', '$graphic_type', 
                        '$image_id', '$igallery_id', '$video_id', '$vgallery_id', 
                        '$posted_on', $is_active, $is_archived )";
		

		$result = mysql_query($this->Query);
		$postid = 0;
		if($result) {
			$postid = mysql_insert_id();
		}		
		return $this->getPostingDetails($postid);
	}
	
	function getPostingDetails($postid) {
		$this->Query = "SELECT posting_id, topic_id, sub_topic_id FROM tbl_posting WHERE posting_id = $postid";
		$result = mysql_query($this->Query);
		return mysql_fetch_array($result);
	}


	function insertPosting($topic_id, $sub_topic_id, $user_id, $title, $post_content, $graphic_type, $image_id, $igallery_id, $video_id, $vgallery_id, $posted_on, $is_active, $is_archived) {
		$title = mysql_real_escape_string($title);
		$post_content = mysql_real_escape_string($post_content);
		$this->Query = "INSERT INTO tbl_posting ( 
                        topic_id, sub_topic_id, user_id, title, post_content, graphic_type, 
                        image_id, igallery_id, video_id, vgallery_id, 
                        posted_on, is_active,is_archived
                        ) VALUES (
                        '$topic_id', '$sub_topic_id', '$user_id', '$title', '$post_content', '$graphic_type', 
                        '$image_id', '$igallery_id', '$video_id', '$vgallery_id', 
                        '$posted_on', $is_active, $is_archived )";

		$result = mysql_query($this->Query) or die(mysql_error());
		return $result;
	}

	function updatePosting($posting_id, $topic_id, $sub_topic_id, $user_id, $title, $post_content, $graphic_type, $image_id, $igallery_id, $video_id, $vgallery_id, $posted_on, $is_active, $is_archived) {
		$title = mysql_real_escape_string($title);
		$post_content = mysql_real_escape_string($post_content);
		
		$this->Query = "UPDATE " . POSTINGS .
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
		$result = mysql_query($this->Query);
		return $result;
	}
	
	function deletePosting($post_id) {
		$disc = $this->OBJDiscussion->deleteDiscussions($post_id);
		$res_sql = false;
		if($disc) {
			$this->Query = "DELETE FROM " . POSTINGS . " WHERE posting_id = $post_id"; // . $post_id;
			$res_sql = mysql_query($this->Query);
		}
		return $res_sql;
	}
	
	function insertRecentlyRead($post_id=0, $user_id=0, $viewed_on='0000-00-00 00:00:00') {
		$this->Query = "SELECT rr_id, post_id, user_id, viewed_on FROM tbl_recentlyread WHERE post_id = '$post_id' AND user_id = '$user_id'";
		$sel_rs = mysql_query($this->Query);
		$rows = mysql_num_rows($sel_rs);
		
		if($rows > 0) {
			$this->Query = "UPDATE tbl_recentlyread 
						SET
							viewed_on = '$viewed_on'
						WHERE post_id = '$post_id' AND user_id = '$user_id'";
		}
		else {
			$this->Query = "INSERT INTO tbl_recentlyread (post_id, user_id, viewed_on)
						VALUES('$post_id', '$user_id', '$viewed_on')";
		}
		mysql_query($this->Query);
	}
	
	function setRecentlyViewed($post_id=null, $user_id=null) {
		$dtime = date('Y-m-d H:i:s');
		if($user_id != null || $user_id != "") {
			$this->insertRecentlyRead($post_id, $user_id, $dtime);
		}
		$this->Query = "UPDATE " . POSTINGS . " SET recently_viewed='$dtime', total_read = (total_read + 1) WHERE posting_id = " . $post_id;
		$res_sql = mysql_query($this->Query);
		return $res_sql;
	}
	
	function incTotalRead($post_id=null) {
		$this->Query = "UPDATE " . POSTINGS . " SET total_read = (total_read + 1) WHERE posting_id = " . $post_id;
		mysql_query($this->Query);
	}
	
	function getRecentPostings($user_id="", $limit=5) {
		 /*
		 $this->Query = " SELECT 	
						posting_id, 
						topic_id, 
						sub_topic_id, 
						user_id, 
						CASE WHEN LENGTH(title) > 23 THEN CONCAT(substr(title, 1, 23) , '...' ) ELSE title END as posttitle,
						CASE WHEN LENGTH(post_content) > 23 THEN CONCAT(substr(post_content, 1, 23) , '...' ) ELSE post_content END as content,
						CASE WHEN LENGTH(post_content) > 18 THEN CONCAT(substr(post_content, 1, 18) , '...' ) ELSE post_content END as ic_content,
						total_read,
						recently_viewed, 
						posted_on,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=posting_id AND for_discussion_id=0) AS counts
					FROM " . POSTINGS . " ORDER BY recently_viewed DESC LIMIT $limit ";
		*/
		
		$condition = "";
		if($user_id != "") {
			$condition .= " AND RR.user_id = $user_id ";
		}
		
		$this->Query = "SELECT 	
							post.posting_id, 
							post.topic_id, 
							post.sub_topic_id, 
							post.user_id, 
							CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(substr(post.title, 1, 23) , '...' ) ELSE post.title END as posttitle,
							CASE WHEN LENGTH(post.post_content) > 23 THEN CONCAT(substr(post.post_content, 1, 23) , '...' ) ELSE post.post_content END as content,
							CASE WHEN LENGTH(post.post_content) > 18 THEN CONCAT(substr(post.post_content, 1, 18) , '...' ) ELSE post.post_content END as ic_content,
							post.total_read,
							post.recently_viewed, 
							post.posted_on,
							RR.viewed_on,
							(SELECT COUNT(*) FROM tbl_discussion WHERE post_id=post.posting_id AND for_discussion_id=0) AS counts
						FROM tbl_posting AS post
						LEFT JOIN tbl_recentlyread AS RR ON (post.posting_id = RR.post_id)
						WHERE RR.user_id = post.user_id $condition ORDER BY RR.viewed_on DESC LIMIT 5";
				
		$result = mysql_query($this->Query);
		return $result;
	}
	
	function getMostPopularPostings($limit=4) {
		$this->Query = " SELECT 
							t1.posting_id,
							t1.topic_id,
							t1.sub_topic_id,
							tmp.posttitle, 
							tmp.content,
							tmp.disc_total,
							(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=t1.posting_id AND for_discussion_id=0) AS counts
						FROM

						(SELECT posting_id, 
							CASE WHEN LENGTH(title) > 27 THEN CONCAT(SUBSTR(title, 1, 27) , '...' ) ELSE title END AS posttitle,
							CASE WHEN LENGTH(post_content) > 27 THEN CONCAT(SUBSTR(post_content, 1, 27) , '...' ) ELSE post_content END AS content,
							disc_total
							FROM  " . POSTINGS . "  ORDER BY disc_total DESC LIMIT $limit) AS tmp,  " . POSTINGS . "  AS t1 

						WHERE t1.posting_id=tmp.posting_id ORDER BY tmp.posttitle ASC ";
		
		$result = mysql_query($this->Query) or die(mysql_error());
		return $result;
	}
	
	function mark_posts($user_id, $post_ids) {
		//MARKED_POSTS
		$is_active = 0;
		$is_archived = 0;
		$marked_on = date("Y-m-d H:i:s");

		foreach ($post_ids as $k => $post_id) {

			$this->Query = "INSERT INTO " . MARKED_POSTS . " (post_id, user_id, marked_on, is_active, is_archived )
                        VALUES ('$post_id', '$user_id', '$marked_on', $is_active, $is_archived)";
			$res_sql = mysql_query($this->Query) or die("INVALID QUERY" . mysql_error());
		}
	}
	
	function get_icPostings($user_id='', $is_marked = false, $Order='ASC', $limit='', $sort="0", $iauthor="", $MY_RECENTS=""){
		$condition = " WHERE 1=1 ";
		$sq_cond = " WHERE 1=1 ";
		
		$OrderBy = "";
		if($sort == "0") {
			$OrderBy .= " ORDER BY viewed_on DESC ";
		} else if($sort == "1") {
			$OrderBy .= " ORDER BY subtopic $Order ";
		} else if ($sort == "2") {
			$OrderBy .= " ORDER BY uname DESC ";
		} else if ($sort == "3") {
			$OrderBy .= " ORDER BY mine DESC ";
		} else if ($sort == "4") {
			$OrderBy .= " ORDER BY recentdiscussion DESC ";
		} else if ($sort == "5") {
			$OrderBy .= " ORDER BY mine DESC ";
		} else if ($sort == "6") {
			$OrderBy = " ORDER BY recentdiscussion DESC ";
		} else if ($sort == "7") {
			$OrderBy .= " ORDER BY iwrt DESC ";
		} else {
			$OrderBy .= " ORDER BY viewed_on DESC ";
		}
		$view_on = "";
		$leftjoin = "";
		if($MY_RECENTS == "IREAD") {
			$view_on = " rr.viewed_on, ";
			$leftjoin = " LEFT JOIN tbl_recentlyread AS rr ON (rr.post_id = post.posting_id) ";
			$condition .= " AND rr.user_id=$user_id ";
		}
		/*
		 if($sort == "0") {
			$OrderBy .= " ORDER BY subtopic $Order ";
		} else if($sort == "1") {
			$OrderBy .= " ORDER BY subtopic $Order ";
		} else if ($sort == "2") {
			$OrderBy .= " ORDER BY uname DESC ";
		} else if ($sort == "3") {
			$OrderBy .= " ORDER BY mostresponded DESC ";
		} else if ($sort == "4") {
			$OrderBy .= " ORDER BY posted_on DESC ";
		} else if ($sort == "5") {
			$OrderBy .= " ORDER BY mine DESC ";
		} else if ($sort == "6") {
			$OrderBy = " ORDER BY recentdiscussion DESC ";
		} else if ($sort == "7") {
			$OrderBy .= " ORDER BY iwasrespondedto DESC ";
		} else {
			$OrderBy .= " ORDER BY post.recently_viewed DESC ";
		}
		 */
		
		
		$select= "SELECT 
						tpc.title AS topic,
						stpc.title AS subtopic, 
						post.posting_id, 
						post.topic_id, 
						post.sub_topic_id, 
						post.user_id, 
						post.title, 
						post.total_read,
						CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(SUBSTR(post.title, 1, 23) , '...' ) ELSE post.title END AS posttitle,
						post.post_content,
						CASE WHEN LENGTH(post.post_content) > 27 THEN CONCAT(SUBSTR(post.post_content, 1, 27) , '...' ) ELSE post.post_content END AS content,
						CASE WHEN LENGTH(post.post_content) > 20 THEN CONCAT(SUBSTR(post.post_content, 1, 20) , '...' ) ELSE post.post_content END AS ic_content,
						post.graphic_type, 
						post.image_id, 
						post.video_id, 
						post.posted_on, 
						post.recently_viewed, 
						DATE_FORMAT(post.posted_on, '%b %d, %Y at %l:%i %p') as posted_date,  
						CAST(post.is_active AS UNSIGNED INT) AS is_active,
						CAST(post.is_archived AS UNSIGNED INT) AS is_archived,
						img.image_name,
						igl.igallery_name,
						vdo.video_name,
						vgl.vgallery_name,
						mrk.mark_id,
						mrk.user_id AS mrkuser,
						CONCAT_WS(' ', upf.first_Name, upf.last_Name) AS uname,
						$view_on
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND for_discussion_id=0) AS counts,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id=$user_id AND for_discussion_id<>0) AS mine,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id<>$user_id AND for_discussion_id<>0) AS others,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id = post.posting_id AND user_id<>$user_id AND for_discussion_id != 0 AND discussion_id NOT IN (SELECT DR.discussion_id FROM " . DISCUSSION_READ . " AS DR WHERE DR.user_id=$user_id)) AS newpost,
						(SELECT posted_on FROM " . DISCUSSION . " WHERE post_id = post.posting_id ORDER BY posted_on DESC LIMIT 1) recentdiscussion,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id = post.posting_id AND for_discussion_id<>0) AS mostresponded,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE user_id=$user_id AND for_discussion_id IN (SELECT td.for_discussion_id FROM " . DISCUSSION . " AS td WHERE td.post_id = post.posting_id AND td.user_id<>$user_id AND td.for_discussion_id<>0)) AS iwasrespondedto,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE discussion_id IN (SELECT td.for_discussion_id FROM  " . DISCUSSION . "  AS td WHERE td.post_id = post.posting_id AND td.user_id<>$user_id AND td.for_discussion_id IN (SELECT discussion_id FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id=$user_id))) AS iwrt
					FROM  
						 " . POSTINGS . " AS post  
						LEFT JOIN " . IMAGES . "  AS img ON (post.image_id = img.image_id)
						LEFT JOIN " . IGALLERY . "  AS igl ON (img.igallery_id = igl.igallery_id)
						LEFT JOIN " . VIDEOS . " AS vdo ON (post.video_id = vdo.video_id)
						LEFT JOIN " . VGALLERY . " AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
						LEFT JOIN " . TOPICS . " AS tpc ON (tpc.topics_id = post.topic_id)
						LEFT JOIN " . SUB_TOPICS . " AS stpc ON (stpc.sub_topic_id = post.sub_topic_id)
						LEFT JOIN " . USERPROFILE . " AS upf ON (upf.user_id = post.user_id) 
						LEFT JOIN " . MARKED_POSTS . " AS mrk ON (mrk.post_id = post.posting_id) $leftjoin ";
		
		if ($user_id != '') {
			$sq_cond .= " AND mk.user_id = " . $user_id;
		}
		
		if($iauthor != ""){
			$condition .= " AND post.user_id = " . $iauthor;
		}
		
		if($is_marked) {
			$condition .= " AND post.posting_id IN ( SELECT mk.post_id FROM " . MARKED_POSTS . " as mk $sq_cond )";
		}
		
		$RecLimit = "";
		if ($limit != '') {
			$RecLimit = " LIMIT $limit ";
		}

		$this->Query = $select . $condition . $OrderBy . $RecLimit;
		//$this->log->lwrite($this->Query);
		$result = mysql_query($this->Query);
		return $result;
	}
	
	
	
	function get_icPostDiscussions($user_id='', $is_marked = false, $Order='ASC', $limit='', $sort="0"){
		$condition = " WHERE 1=1 ";
		$sq_cond = " WHERE 1=1 ";
		
		$OrderBy = "";
		if($sort == "0") {
			//article
			$OrderBy .= " ORDER BY subtopic $Order ";
		} else if($sort == "1") {
			//article
			$OrderBy .= " ORDER BY subtopic $Order ";
		} else if ($sort == "2") {
			//user
			$OrderBy .= " ORDER BY uname DESC ";
		} else if ($sort == "3") {
			//most Responded
			//$OrderBy .= " ORDER BY mostresponded DESC ";
			$OrderBy .= " ORDER BY mine DESC ";
		} else if ($sort == "4") {
			//most recent discussions
			$OrderBy .= " ORDER BY recentdiscussion DESC ";
		} else if ($sort == "5") {
			//my responces
			// -$condition .= " AND post.posting_id IN (SELECT post_id FROM " . DISCUSSION . " WHERE user_id=$user_id AND for_discussion_id<>0)";
			$OrderBy .= " ORDER BY mine DESC ";
		} else if ($sort == "6") {
			//recent discussion
			$OrderBy = " ORDER BY recentdiscussion DESC ";
		} else if ($sort == "7") {
			// i was responded to-
			// -$condition .= " AND post.posting_id IN (SELECT post_id FROM " . DISCUSSION . " WHERE user_id=$user_id AND for_discussion_id IN (SELECT td.for_discussion_id FROM " . DISCUSSION . " AS td WHERE td.post_id = post.posting_id AND td.user_id<>$user_id AND td.for_discussion_id<>0))";
			$OrderBy .= " ORDER BY iwrt DESC ";
		} else {
			$OrderBy .= " ORDER BY post.posted_on DESC ";
		}
		
		$select= "SELECT 
						tpc.title AS topic,
						stpc.title AS subtopic, 
						post.posting_id, 
						post.topic_id, 
						post.sub_topic_id, 
						post.user_id, 
						post.title, 
						post.total_read,
						CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(SUBSTR(post.title, 1, 23) , '...' ) ELSE post.title END AS posttitle,
						post.post_content,
						CASE WHEN LENGTH(post.post_content) > 27 THEN CONCAT(SUBSTR(post.post_content, 1, 27) , '...' ) ELSE post.post_content END AS content,
						CASE WHEN LENGTH(post.post_content) > 20 THEN CONCAT(SUBSTR(post.post_content, 1, 20) , '...' ) ELSE post.post_content END AS ic_content,
						post.graphic_type, 
						post.image_id, 
						post.video_id, 
						post.posted_on, 
						DATE_FORMAT(post.posted_on, '%b %d, %Y at %l:%i %p') as posted_date,  
						CAST(post.is_active AS UNSIGNED INT) AS is_active,
						CAST(post.is_archived AS UNSIGNED INT) AS is_archived,
						img.image_name,
						igl.igallery_name,
						vdo.video_name,
						vgl.vgallery_name,
						mrk.mark_id,
						mrk.user_id AS mrkuser,
						CONCAT_WS(' ', upf.first_Name, upf.last_Name) AS uname,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND for_discussion_id=0) AS counts,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id=$user_id AND for_discussion_id<>0) AS mine,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id<>$user_id AND for_discussion_id<>0) AS others,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id = post.posting_id AND user_id<>$user_id AND for_discussion_id != 0 AND discussion_id NOT IN (SELECT DR.discussion_id FROM " . DISCUSSION_READ . " AS DR WHERE DR.user_id=$user_id)) AS newpost,
						(SELECT posted_on FROM " . DISCUSSION . " WHERE post_id = post.posting_id ORDER BY posted_on DESC LIMIT 1) recentdiscussion,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id = post.posting_id AND for_discussion_id<>0) AS mostresponded,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE user_id=$user_id AND for_discussion_id IN (SELECT td.for_discussion_id FROM " . DISCUSSION . " AS td WHERE td.post_id = post.posting_id AND td.user_id<>$user_id AND td.for_discussion_id<>0)) AS iwasrespondedto,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE discussion_id IN (SELECT td.for_discussion_id FROM  " . DISCUSSION . "  AS td WHERE td.post_id = post.posting_id AND td.user_id<>$user_id AND td.for_discussion_id IN (SELECT discussion_id FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id=$user_id))) AS iwrt
					FROM  
						 " . POSTINGS . "   AS post  
						LEFT JOIN " . IMAGES . "  AS img ON (post.image_id = img.image_id)
						LEFT JOIN " . IGALLERY . "  AS igl ON (img.igallery_id = igl.igallery_id)
						LEFT JOIN " . VIDEOS . " AS vdo ON (post.video_id = vdo.video_id)
						LEFT JOIN " . VGALLERY . " AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
						LEFT JOIN " . TOPICS . " AS tpc ON (tpc.topics_id = post.topic_id)
						LEFT JOIN " . SUB_TOPICS . " AS stpc ON (stpc.sub_topic_id = post.sub_topic_id)
						LEFT JOIN " . USERPROFILE . " AS upf ON (upf.user_id = post.user_id) 
						LEFT JOIN " . MARKED_POSTS . " AS mrk ON (mrk.post_id = post.posting_id) ";
		
		if ($user_id != '') {
			$sq_cond .= " AND mk.user_id = " . $user_id;
		}
		if($is_marked) {
			$condition .= " AND post.posting_id IN ( SELECT mk.post_id FROM " . MARKED_POSTS . " as mk $sq_cond) ";
		}
		
		$RecLimit = "";
		if ($limit != '') {
			$RecLimit = " LIMIT $limit ";
		}

		$this->Query = $select . $condition . $OrderBy . $RecLimit;
		//$this->log->lwrite($this->Query . "LAL$sort");
		$result = mysql_query($this->Query);
		return $result;
	}
	
	
	/*
	function get_icPostings($user_id='', $is_marked = false, $Order='ASC', $limit='', $sort="0"){
		$condition = " WHERE 1=1 ";
		$sq_cond = " WHERE 1=1 ";
		
		$select= "SELECT 
						tpc.title AS topic,
						stpc.title AS subtopic, 
						post.posting_id, 
						post.topic_id, 
						post.sub_topic_id, 
						post.user_id, 
						post.title, 
						post.total_read,
						CASE WHEN LENGTH(post.title) > 23 THEN CONCAT(SUBSTR(post.title, 1, 23) , '...' ) ELSE post.title END AS posttitle,
						post.post_content,
						CASE WHEN LENGTH(post.post_content) > 27 THEN CONCAT(SUBSTR(post.post_content, 1, 27) , '...' ) ELSE post.post_content END AS content,
						CASE WHEN LENGTH(post.post_content) > 20 THEN CONCAT(SUBSTR(post.post_content, 1, 20) , '...' ) ELSE post.post_content END AS ic_content,
						post.graphic_type, 
						post.image_id, 
						post.video_id, 
						post.posted_on, 
						DATE_FORMAT(post.posted_on, '%b %d, %Y at %l:%i %p') as posted_date,  
						CAST(post.is_active AS UNSIGNED INT) AS is_active,
						CAST(post.is_archived AS UNSIGNED INT) AS is_archived,
						img.image_name,
						igl.igallery_name,
						vdo.video_name,
						vgl.vgallery_name,
						mrk.mark_id,
						mrk.user_id AS mrkuser,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND for_discussion_id=0) AS counts,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id=$user_id AND for_discussion_id<>0) AS mine,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND user_id<>$user_id AND for_discussion_id<>0) AS others,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id = post.posting_id AND user_id<>$user_id AND for_discussion_id != 0 AND discussion_id NOT IN (SELECT DR.discussion_id FROM " . DISCUSSION_READ . " AS DR WHERE DR.user_id=$user_id)) AS newpost
					FROM  
						 " . POSTINGS . "   AS post  
						LEFT JOIN " . IMAGES . "  AS img ON (post.image_id = img.image_id)
						LEFT JOIN " . IGALLERY . "  AS igl ON (img.igallery_id = igl.igallery_id)
						LEFT JOIN " . VIDEOS . " AS vdo ON (post.video_id = vdo.video_id)
						LEFT JOIN " . VGALLERY . " AS vgl ON (vdo.vgallery_id = vgl.vgallery_id)
						LEFT JOIN " . TOPICS . " AS tpc ON (tpc.topics_id = post.topic_id)
						LEFT JOIN " . SUB_TOPICS . " AS stpc ON (stpc.sub_topic_id = post.sub_topic_id)
						LEFT JOIN " . MARKED_POSTS . " AS mrk ON (mrk.post_id = post.posting_id) ";
		
		//(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=post.posting_id AND posted_on > (SELECT inr.posted_on FROM " . DISCUSSION . " AS inr WHERE inr.post_id=post.posting_id AND user_id=$user_id ORDER BY inr.posted_on DESC LIMIT 1)) AS newpost
		if ($user_id != '') {
			//$condition .= " AND post.user_id = " . $user_id;
			$sq_cond .= " AND mk.user_id = " . $user_id;
		}
		if($is_marked) {
			$condition .= " AND post.posting_id IN ( SELECT mk.post_id FROM " . MARKED_POSTS . " as mk $sq_cond )";
		}
		
		$RecLimit = "";
		if ($limit != '') {
			$RecLimit = " LIMIT $limit ";
		}

		$OrderBy = " ORDER BY subtopic $Order ";  //" ORDER BY posted_on $Order ";
		
		$this->Query = $select . $condition . $OrderBy . $RecLimit;
		//$this->log->lwrite($this->Query);
		$result = mysql_query($this->Query);
		return $result;
	} */
	
	
	function getBadWords() {
		$this->Query = " SELECT	bw_word FROM " . BAD_WORDS;
		$res = mysql_query($this->Query);
		while ($row = mysql_fetch_assoc($res)) {
			$this->badwords[] = $row['bw_word'];
		}
	}
	
	function badword_filter($content) {
		$this->getBadWords();
		$count = count($this->badwords);
		$original = $content;
		$content = strtolower($content);
		// Loop through the badwords array
		for ($n = 0; $n < $count; ++$n, next($this->badwords)) {
			//Search for badwords in content
			$search = trim(strtolower($this->badwords[$n]));
			$content = preg_replace("'$search'iu", "<i>$search</i>", $content);
			//$this->log->lwrite($content);
		}
		
		if(mb_strlen($original) == mb_strlen($content)) {
			return 1;
		}
		return 0;
	}
	
	function cleanText($str) {
		$str = str_replace("Ñ", "", $str);
		$str = str_replace("ñ", "", $str);
		$str = str_replace("ñ", "", $str);
		$str = str_replace("Á", "", $str);
		$str = str_replace("á", "", $str);
		$str = str_replace("É", "", $str);
		$str = str_replace("é", "", $str);
		$str = str_replace("ú", "", $str);
		$str = str_replace("ù", "", $str);
		$str = str_replace("Í", "", $str);
		$str = str_replace("í", "", $str);
		$str = str_replace("Ó", "", $str);
		$str = str_replace("ó", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace(".", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("_", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace("ü", "", $str);
		$str = str_replace("Ü", "", $str);
		$str = str_replace("Ê", "", $str);
		$str = str_replace("ê", "", $str);
		$str = str_replace("Ç", "", $str);
		$str = str_replace("ç", "", $str);
		$str = str_replace("È", "", $str);
		$str = str_replace("è", "", $str);
		$str = str_replace("?", "", $str);
		$str = str_replace(">", "", $str);
		$str = str_replace("<", "", $str);
		$str = str_replace("{", "", $str);
		$str = str_replace("}", "", $str);
		$str = str_replace("|", "", $str);
		$str = str_replace("(", "", $str);
		$str = str_replace(")", "", $str);
		$str = str_replace("*", "", $str);
		$str = str_replace("#", "", $str);
		$str = str_replace("$", "", $str);
		$str = str_replace("!", "", $str);
		return $str;
	}
	function filter_malicious($content) {
		$this->getBadWords();
		$count = count($this->badwords);
		$content = $this->cleanText(strtolower($content));
		$content_arr = $this->split_words($content);
		$bw_count = 0;
		// Loop through the badwords array
		for ($n = 0; $n < $count; ++$n, next($this->badwords)) {
			//Search for badwords in content
			$search = trim(strtolower($this->badwords[$n]));
			if(in_array($search, $content_arr)) {
				$bw_count++;
			}
		}
		if($bw_count == 0) {
			return 1;
		}
		return 0;
	}

	function split_words($string, $max = 1) {
		$words = preg_split('/\s/', $string);
		$lines = array();
		$line = '';

		foreach ($words as $k => $word) {
			$length = strlen($line . ' ' . $word);
			if ($length <= $max) {
				$line .= ' ' . $word;
			} else if ($length > $max) {
				if (!empty($line))
					$lines[] = trim($line);
				$line = $word;
			} else {
				$lines[] = trim($line) . ' ' . $word;
				$line = '';
			}
		}
		$lines[] = ($line = trim($line)) ? $line : $word;

		return $lines;
	}

	
	
	function getUserPosts ($user_id='', $Order='DESC', $limit='5'){
		$this->Query = " SELECT 	
						posting_id, 
						topic_id, 
						sub_topic_id, 
						user_id, 
						CASE WHEN LENGTH(title) > 18 THEN CONCAT(substr(title, 1, 18) , '...' ) ELSE title END as posttitle,
						CASE WHEN LENGTH(post_content) > 18 THEN CONCAT(substr(post_content, 1, 18) , '...' ) ELSE post_content END as ic_content,
						total_read,
						recently_viewed, 
						posted_on,
						(SELECT COUNT(*) FROM " . DISCUSSION . " WHERE post_id=posting_id AND for_discussion_id=0) AS counts
					FROM " . POSTINGS . " WHERE user_id = $user_id ORDER BY posted_on DESC LIMIT $limit ";
		
		$result = mysql_query($this->Query);
		return $result;
	}
	
	function __destruct() {
		
	}
}

?>