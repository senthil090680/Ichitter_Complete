<?php

class subtopics {

	var $TOPICS_ID;
	var $TITLE;
	var $DESCRIPTION;
	var $IMAGE;
	var $IMAGE_ID;
	var $USER;
	var $QUERY;
	var $l;

	function __construct() {
		$this->QUERY = "";
		//$this->l = new Logging();
	}
	
	function set_topics($title, $description, $image, $topics_id, $userid='0', $image_id='0') {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
		$this->TOPICS_ID = $topics_id;
		$this->USER = $userid;
		$this->IMAGE_ID = $image_id;
	}
	
	function get_topics($title, $description, $image, $topics_id) {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
		$this->TOPICS_ID = $topics_id;
	}
	
	function incSubTopicOrderPriority() {
		//$this->QUERY = " SELECT * FROM tbl_subtopic_order WHERE user_id = '" . $this->USER . "' AND topic_id ='" . $this->TOPICS_ID . "'"; 
		//$stoRS = mysql_query($this->QUERY);
		
		//while ($row = mysql_fetch_array($query)) {
		$this->QUERY = "UPDATE " . SUBTOPIC_ORDER . " SET priority_order = (priority_order + 1) WHERE topic_id = " . $this->TOPICS_ID . " AND user_id = " . $this->USER;
		mysql_query($this->QUERY);
		//}
	}

	function incSubTopicPriority() {
		$this->QUERY = "UPDATE " . SUB_TOPICS . " SET priority = (priority + 1) WHERE topic_id = " . $this->TOPICS_ID;
		//$this->QUERY = "UPDATE tbl_subtopic_order SET priority_order = (priority_order + 1) WHERE user_id = " . $this->USER;
		mysql_query($this->QUERY);
	}
	
	function insertSubTopicOrder() {
		$selSubTopics = "SELECT * FROM tbl_sub_topics WHERE topic_id = " . $this->TOPICS_ID;
		$stRS = mysql_query($selSubTopics);
		$stRS_cnt = mysql_num_rows($stRS);
		
		$selSubTopicsOrder = "SELECT * FROM tbl_subtopic_order WHERE topic_id = " . $this->TOPICS_ID . " AND user_id=" . $this->USER;
		$stoRS = mysql_query($selSubTopicsOrder);
		$stoRS_cnt = mysql_num_rows($stoRS);
		
		if($stRS_cnt > $stoRS_cnt) {
			$i = 1;
			while ($row = mysql_fetch_array($stRS)) {
				$select = " SELECT * FROM tbl_subtopic_order WHERE user_id = '" . $this->USER . "' AND topic_id ='" . $row['topic_id'] . "' AND sub_topic_id ='" . $row['sub_topic_id'] . "'"; 
				$selectRS = mysql_query($select);
				$selectRS_cnt = mysql_num_rows($selectRS); 
				if($selectRS_cnt < 1) {
					$maxPrioritySQL = "SELECT IFNULL(MAX(priority_order) + 1, 1) AS maxpri FROM tbl_subtopic_order WHERE user_id = '" . $this->USER . "' AND topic_id ='" . $row['topic_id'] . "'"; 
					$max_RS = mysql_query($maxPrioritySQL);
					$max_RS_Row = mysql_fetch_array($max_RS);
					$maxPriority = $max_RS_Row['maxpri'];
					$insert_priority = "INSERT INTO tbl_subtopic_order 
									(user_id, topic_id, sub_topic_id,  priority_order)
								VALUES ('" . $this->USER . "', '" . $row['topic_id'] . "', '" . $row['sub_topic_id'] . "','$maxPriority')";
					mysql_query($insert_priority);
				} else {
					 $update_priority =	" UPDATE tbl_subtopic_order 
										SET
											user_id = '" . $this->USER . "' , 
											topic_id = '" . $row['topic_id'] . "' , 
											sub_topic_id = '" . $row['sub_topic_id'] . "' , 
											priority_order = '$i'
										WHERE
											user_id = '" . $this->USER . "' AND topic_id ='" . $row['topic_id'] . "' AND sub_topic_id ='" . $row['sub_topic_id'] . "'"; 
					 mysql_query($update_priority);
				 }
				$i++;
			}
		}
	}
	
	function getMaxSubTopicPriority($topicid) {
		$this->QUERY = "SELECT max(priority) AS prty FROM " . SUB_TOPICS  . " WHERE topic_id = $topicid";
		$rs = mysql_query($this->QUERY);
		$rs_arr = mysql_fetch_array($rs);
		return $rs_arr['prty'] + 1;
	}

	function insert_topics() {
		$created_date = date("Y-m-d");
		$allow = false;
		//$this->incSubTopicPriority();		
		//$this->QUERY = "SELECT max( priority ) FROM " . SUB_TOPICS;
		//$priority = mysql_query($this->QUERY);
		//$priority_cnt = mysql_fetch_array($priority);
		
		$this->QUERY = "SELECT * FROM " . SUB_TOPICS . " WHERE title ='" . $this->TITLE . "' ";
		$res = mysql_query($this->QUERY);
		if (mysql_num_rows($res) == 0) {
			$this->insertSubTopicOrder();
			$this->incSubTopicOrderPriority();
			//$this->incSubTopicPriority();
			$this->QUERY = "INSERT INTO 
							" . SUB_TOPICS . " 
								(topic_id, 
									title, 
										description, 
											image, 
												priority, 
													created_date, 
														is_archieved, 
															user_id,
																image_id) 
							VALUES
							('" . $this->TOPICS_ID . "', 
								'" . $this->TITLE . "', 
									'" . $this->DESCRIPTION . "', 
										'" . $this->IMAGE . "', 
											'" . $this->getMaxSubTopicPriority($this->TOPICS_ID) . "',
												'" . $created_date . "',
													'', 
													'" . $this->USER . "',
														'" . $this->IMAGE_ID . "')";
			$res_sql = mysql_query($this->QUERY);
			//$subtopic_id = mysql_insert_id();
			
			$insert_priority = "INSERT INTO tbl_subtopic_order (user_id, topic_id, sub_topic_id,  priority_order)
								VALUES ('" . $this->USER . "', '" . $this->TOPICS_ID . "', (SELECT MAX(sub_topic_id) FROM tbl_sub_topics), '". (1) ."')";
			mysql_query($insert_priority);
			
			$allow = true;
		}
		return $allow;
	}

	function get_alltopics($limit) {
		$this->QUERY = "SELECT sub_topic_id, topic_id, title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date FROM " . SUB_TOPICS . ' ORDER BY sub_topic_id DESC  LIMIT ' . $limit;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_allSubtopics($limit, $topicsid) {
		if ($limit == 0) {
			$this->QUERY = "SELECT 
								sub_topic_id,
								topic_id,
								title, 
								CASE WHEN LENGTH(description) > 30 THEN CONCAT(substr(description, 1, 30 ), '...') ELSE description END , 
								image, 
								created_date 
							FROM " . SUB_TOPICS . ' 
							WHERE topic_id = ' . $topicsid;
		} else {
			$this->QUERY = "SELECT 
								sub_topic_id,
								topic_id,
								title, 
								CASE WHEN LENGTH(description) > 30 THEN CONCAT(substr(description, 1, 30 ), '...') ELSE description END , 
								image, 
								created_date 
							FROM " . SUB_TOPICS . ' 
							WHERE topic_id = ' . $topicsid . ' 
								LIMIT ' . $limit;
		}
		$result = mysql_query($this->QUERY);

		return $result;
		//return "select sub_topic_id,topic_id,title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date from ".SUB_TOPICS. ' where topic_id='.$topicsid.' limit ' .$limit;
	}
	
	function getSubTopicsByUser($topicsid="", $userid="", $limit="") {
		$condition = " WHERE 1=1 ";
		$limitation = "";
		if($topicsid != "") {
			$condition .= " AND topic_id=$topicsid ";
		}
		if($userid != "") {
			$condition .= " AND user_id=$userid ";
		}
		
		if($limit != '') {
			$limitation = " LIMIT $limit ";
		}
		
		$this->QUERY = "SELECT 
					STP.sub_topic_id,
					STP.topic_id,
					STP.title, 
					STP.user_id,
					STPO.priority_order
				FROM tbl_sub_topics AS STP
					LEFT JOIN tbl_subtopic_order AS STPO ON (STPO.sub_topic_id = STP.sub_topic_id)
				WHERE STP.user_id = $userid AND STPO.user_id = $userid  AND STPO.topic_id = $topicsid 
				ORDER BY STPO.priority_order ";
		
		/*
		$select = "SELECT 
						sub_topic_id,
						topic_id,
						title, 
						user_id, 
						CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , 
						image, 
						created_date 
					FROM " . SUB_TOPICS ;
		*/
		//$this->QUERY = $select . $condition . $limitation;
		
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_allthetopics() {
		$this->QUERY = "SELECT 
							sub_topic_id,
							topic_id,
							title, 
							CASE WHEN LENGTH(description) > 30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END, 
							image, 
							created_date 
						FROM " . SUB_TOPICS;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsCount() {
		$this->QUERY = "SELECT COUNT(*) FROM " . SUB_TOPICS;
		$result = mysql_query($this->QUERY);
		$row = mysql_fetch_array($result);
		$total = $row[0];
		return $total;
	}
	
	function getSubTopicsCount($tid = null) {
		$condition = " WHERE 1=1";
		
		if(($tid != "") && ($tid != null)) {
			$condition .= " AND topic_id = $tid ";
		}
		$this->QUERY = "SELECT COUNT(*) AS total FROM " . SUB_TOPICS . " " . $condition;
		$result = mysql_query($this->QUERY);
		$row = mysql_fetch_assoc($result);
		$total = $row['total'];
		return $total;
	}

	function get_topicsByPriority($topicid) {
		$this->QUERY = "SELECT 
							sub_topic_id, 
							topic_id,
							title,
							priority 
						FROM " . SUB_TOPICS . " 
						WHERE topic_id=" . $topicid . " ORDER BY priority";
		$result = mysql_query($this->QUERY) or die(mysql_error());
		
		return $result;
	}
	
	function reorderSubTopicsByUser($userid="0", $order="", $topicid="0"){
		if($order != "") {
			$lstItem = explode(',', $order);
			if(count($lstItem) > 0) {
				foreach ($lstItem as $position => $subtopicid) :
					$this->QUERY = " UPDATE " . SUBTOPIC_ORDER . "  
									SET priority_order = ($position + 1) 
									WHERE user_id = '$userid' AND sub_topic_id = '$subtopicid' ";
					mysql_query($this->QUERY);
				endforeach;
				
				$this->QUERY = "SELECT MAX(STPO.priority_order) as porder 
								FROM 
									tbl_subtopic_order AS STPO
								WHERE 
									STPO.user_id = $userid 
									AND STPO.topic_id = $topicid 
									AND STPO.sub_topic_id IN (
																SELECT STP.sub_topic_id 
																FROM tbl_sub_topics AS STP
																WHERE STP.user_id = $userid AND STP.topic_id=$topicid
															) ";
				$res = mysql_query($this->QUERY);
				$max_porder = mysql_fetch_array($res);
				$this->QUERY = " SELECT STPO.priority_id AS prtid, STPO.priority_order
									FROM 
										tbl_subtopic_order AS STPO
									WHERE 
										STPO.user_id = $userid 
										AND STPO.topic_id = $topicid 
										AND STPO.sub_topic_id NOT IN (
																	SELECT STP.sub_topic_id 
																	FROM tbl_sub_topics AS STP
																	WHERE STP.user_id = $userid AND STP.topic_id=$topicid) ORDER BY STPO.priority_order ASC ";
				
				$rs_pid = mysql_query($this->QUERY);
				$i = 1;
				$max = $max_porder['porder']; 
				while ($row = mysql_fetch_array($rs_pid)) {
					$this->QUERY = " UPDATE " . SUBTOPIC_ORDER . "  
									SET priority_order = ($max + $i) 
									WHERE priority_id = " . $row ['prtid'];
					
					mysql_query($this->QUERY);
					$i++;
				}
				
			}
		}
	}
	
	function fillSubTopicPriorityForUser($topicid = null, $userid=null) {
		$rs_topics = $this->get_topicsByPriority($topicid);
		$i = 1;
		while ($row = mysql_fetch_array($rs_topics)) {
			$this->QUERY = "INSERT INTO tbl_subtopic_order
									(user_id, sub_topic_id, topic_id,  priority_order)
								VALUES ('" . $userid . "', '" . $row['sub_topic_id'] . "', '" . $row['topic_id'] .  "', '" . $i ."')";
			mysql_query($this->QUERY); 
			$i++;
		}
	}

	function get_topicsByPriorityOrder($limit = null, $topicid = null, $userid=null) {
		$condition = " WHERE 1=1 ";
		if (($topicid != "") && ($topicid != null)) {
			$condition .= " AND st.topic_id = " . $topicid ;
		}
		
		$orderby = "";
		$field = "";
		$leftjoin = "";
		if (($userid != "") && ($userid != null)) {
			$condition .= " AND sto.user_id = " . $userid . " AND sto.topic_id = " . $topicid;
			$orderby = " ORDER BY sto.priority_order ";
			$field = " ,sto.priority_order ";
			$leftjoin = " LEFT JOIN tbl_subtopic_order AS sto ON (sto.sub_topic_id = st.sub_topic_id) ";
		} else {
			$orderby = " ORDER BY st.priority ";
		}

		$limitation = "";
		if (($limit != "") && ($limit != null)) {
			$limitation = " LIMIT $limit ";
		}
/*
		$this->QUERY = "SELECT 
		    sub_topic_id,
		    topic_id, 
		    title, 
		    CASE WHEN LENGTH( description ) >30 THEN CONCAT( substr( description, 1, 30 ) , '...' )  ELSE description END  AS descr , 
		    image, 
		    created_date,
		    priority 
		FROM " . SUB_TOPICS . $condition . " ORDER BY priority " . $limitation;
*/
		
		$this->QUERY = "SELECT 
							st.sub_topic_id,
							st.topic_id, 
							st.title, 
							st.user_id,
							CASE WHEN LENGTH(st.description) > 30 THEN CONCAT(substr(st.description, 1, 30), '...')  ELSE st.description END AS descr, 
							st.image, 
							st.created_date,
							st.priority,
							st.image_id,
							img.image_name,
							img.igallery_id,
							igl.igallery_name
							 $field
						FROM " . SUB_TOPICS . " AS st
						LEFT JOIN " . IMAGES . " AS img ON (img.image_id=st.image_id)
						LEFT JOIN " . IGALLERY . " AS igl ON (igl.igallery_id=img.igallery_id)
						 $leftjoin "
						 . $condition  . $orderby  . $limitation;
		
		$result = mysql_query($this->QUERY);
		//$this->l->lwrite($this->QUERY);
		$recCnt = mysql_num_rows($result);
		if($recCnt < 1) {
			$this->fillSubTopicPriorityForUser($topicid, $userid);
			$result = $this->get_topicsByPriorityOrder($count, $topicid, $userid);
		}
		
		return $result;
	}

	function get_topicsById($subtopicsid) {
		$this->QUERY = "SELECT 
							sub_topic_id,
							topic_id,
							title, 
							description, 
							image, 
							CAST(is_active AS unsigned int) as is_active,CAST(priority AS unsigned int) as priority 
						FROM " . SUB_TOPICS . " 
						WHERE sub_topic_id=" . $subtopicsid;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsTitles($topicid=null, $subtopicsid=null) {

		$where = " WHERE 1=1 ";
		if ($topicid != "" && $topicid != null) {
			$where .= " AND tt.topics_id = $topicid ";
		}

		if ($subtopicsid != "" && $subtopicsid != null) {
			$where .= " AND tst.sub_topic_id = $subtopicsid ";
		}

		$this->QUERY = "SELECT 
		    tst.sub_topic_id,
		    tst.topic_id,
		    tst.title as subtopic, 
		    tt.title as topic, 
		    tst.description, 
		    tst.image, 
		    CAST(tst.is_active AS unsigned int) as is_active,
		    CAST(tst.priority AS unsigned int) as priority 
		FROM " . SUB_TOPICS . " AS tst LEFT JOIN " . TOPICS . " AS tt ON (tst.topic_id = tt.topics_id) ";
		$this->QUERY .= $where;
		//$this->l->lwrite($this->QUERY);
		$result = mysql_query($this->QUERY) or die(mysql_error());
		return $result;
	}

	function update_topics($subtopicid, $isactive, $priority) {
		$this->QUERY = "UPDATE " . SUB_TOPICS . " SET topic_id='" . $this->TOPICS_ID . "', title = '" . $this->TITLE . "', description = '" . $this->DESCRIPTION . "', image = '" . $this->IMAGE . "', is_active=" . $isactive . ", priority='" . $priority . "' WHERE sub_topic_id = " . $subtopicid;
		$res_sql = mysql_query($this->QUERY) or die("INVALID QUERY >> " . mysql_error());
		$allow = true;
		return $allow;
		//return "UPDATE ".SUB_TOPICS." SET topic_id='". $this->TOPICS_ID ."', title = '".$this->TITLE."', description = '".$this->DESCRIPTION."', image = '".$this->IMAGE."', is_active='". $isactive ."', priority='". $priority ."' WHERE sub_topic_id = ".$subtopicid;
	}

	function delete_topics($subtopicsid) {
		$this->QUERY = "DELETE FROM " . SUB_TOPICS . " WHERE sub_topic_id = " . $subtopicsid;
		$res_sql = mysql_query($this->QUERY) or die("INVALID QUERY" . mysql_error());
		$allow = true;
		return $allow;
	}

	function setUploadedFileName($fname) {
		$datetime = date("mdYHis");
		$filecheck = $fname;
		$farr = explode('.', $filecheck);
		$ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
		$fname = $this->replaceSplChars($farr[0]) . "_" . $datetime . "." . $ext;

		return $fname;
	}

	function replaceSplChars($text) {
		$pattern = "/([^A-Za-z0-9])/i";
		$retText = preg_replace($pattern, '_', $text);
		return $retText;
	}

	function getSubTopicById($sub_topic_id) {
		$this->QUERY = "SELECT 
							sub_topic_id, 
							topic_id, 
							title, 
							CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END, 
							image, 
							created_date 
						FROM " . SUB_TOPICS . ' 
						WHERE sub_topic_id = ' . $sub_topic_id;
		$result = mysql_query($this->QUERY);
		return $result;
	}
}
?>
