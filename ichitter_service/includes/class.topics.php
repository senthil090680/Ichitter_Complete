<?php
class topics {

	var $TITLE;
	var $DESC;
	var $IMAGE;
	var $USER;
	var $IMAGE_ID;
	var $log;
	private $QUERY;

	function __construct() {
		//$this->log = new Logging();
		$this->QUERY = "";
	}
	
	function set_topics($title, $description, $image, $user='0', $image_id='0') {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
		$this->USER = $user;
		$this->IMAGE_ID = $image_id;
	}

	function get_topics($title, $description, $image, $user='0') {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
		$this->USER = $user;
	}

	function incTopicPriorityOrder() {
		$this->QUERY = "UPDATE tbl_topic_order SET priority_order = (priority_order + 1) WHERE user_id = " . $this->USER;
		mysql_query($this->QUERY);
	}
	
	function incTopicPriority() {
		$this->QUERY = "UPDATE " . TOPICS . " SET priority = (priority + 1)";
		mysql_query($this->QUERY);
	}
	
	function getMaxTopicPriority() {
		$this->QUERY = "SELECT max(priority) AS prty FROM " . TOPICS;
		$rs = mysql_query($this->QUERY);
		$rs_arr = mysql_fetch_array($rs);
		return $rs_arr['prty'] + 1;
	}
	
	function insertTopicOrder() {
		$selTopics = "SELECT * FROM tbl_topics";
		$stRS = mysql_query($selTopics);
		$stRS_cnt = mysql_num_rows($stRS);
		
		$selTopicsOrder = "SELECT * FROM tbl_topic_order WHERE user_id=" . $this->USER;
		$stoRS = mysql_query($selTopicsOrder);
		$stoRS_cnt = mysql_num_rows($stoRS);
		
		if($stRS_cnt > $stoRS_cnt) {
			$i = 1;
			while ($row = mysql_fetch_array($stRS)) {
				$select = " SELECT * FROM tbl_topic_order WHERE user_id = '" . $this->USER . "' AND topic_id ='" . $row['topics_id'] . "'"; 
				$selectRS = mysql_query($select);
				$selectRS_cnt = mysql_num_rows($selectRS); 
				if($selectRS_cnt < 1) {
					$maxPrioritySQL = "SELECT IFNULL(MAX(priority_order) + 1, 1) AS maxpri FROM tbl_topic_order WHERE user_id = '" . $this->USER . "'"; 
					$max_RS = mysql_query($maxPrioritySQL);
					$max_RS_Row = mysql_fetch_array($max_RS);
					$maxPriority = $max_RS_Row['maxpri'];
					$insert_priority = "INSERT INTO tbl_topic_order 
									(user_id, topic_id, priority_order)
								VALUES ('" . $this->USER . "', '" . $row['topics_id'] . "', '$maxPriority')";
					mysql_query($insert_priority);
				} else {
					 $update_priority =	" UPDATE tbl_topic_order 
										SET
											user_id = '" . $this->USER . "' , 
											topic_id = '" . $row['topics_id'] . "' , 
											priority_order = '$i'
										WHERE
											user_id = '" . $this->USER . "' AND topic_id ='" . $row['topics_id'] . "'"; 
					 mysql_query($update_priority);
				 }
				$i++;
			}
		}
	}

	function insert_topics() {
		$created_date = date("Y-m-d");
		$allow = false;
		//$this->incTopicPriority();
		//$priority = mysql_query("SELECT max(priority) from " . TOPICS);
		//$priority_cnt = mysql_fetch_array($priority);
		$this->QUERY = "SELECT * FROM " . TOPICS . " WHERE title ='" . $this->TITLE . "'";
		$res = mysql_query($this->QUERY);
		if (mysql_num_rows($res) == 0) {
			$this->insertTopicOrder();
			$this->incTopicPriorityOrder();
			//$this->incTopicPriority();
			$this->QUERY = "INSERT INTO 
								" . TOPICS . " 
									(title, 
										description, 
											image,priority, 
												created_date, 
													user_id,
														image_id
								) VALUES(
								'" . $this->TITLE . "', 
									'" . $this->DESCRIPTION . "', 
										'" . $this->IMAGE . "', 
											'" . $this->getMaxTopicPriority() . "', 
												'" . $created_date . "', 
													'" . $this->USER . "',
														'" . $this->IMAGE_ID . "')";
			$res_sql = mysql_query($this->QUERY);
			$insert_priority = "INSERT INTO tbl_topic_order 
									(user_id, topic_id,  priority_order)
								VALUES ('" . $this->USER . "', (SELECT MAX(topics_id) FROM tbl_topics), '". (1) ."')";
			mysql_query($insert_priority);
			$allow = true;
		} else {
			$allow = false;
		}
		return $allow;
	}
	
	/*
	function insert_topics() {
		$created_date = date("Y-m-d");
		$this->incTopicPriority();
		$priority = mysql_query("SELECT max( priority ) from " . TOPICS) or die(mysql_error());
		$res = mysql_query("select * from " . TOPICS . " WHERE title ='" . $this->TITLE . "' ") or die(mysql_error());

		$priority_cnt = mysql_fetch_array($priority);
			
		if (mysql_num_rows($res) == 0) {
			//$sql =    "INSERT INTO ".TOPICS." (title, description, image,priority, created_date) VALUES('".$this->TITLE."', '".$this->DESCRIPTION."', '".$this->IMAGE."','". $priority_cnt ."','"$created_date."')";
			//$sql =    "INSERT INTO ".TOPICS." (title, description, image,priority, created_date) VALUES('".$this->TITLE."', '".$this->DESCRIPTION."', '".$this->IMAGE."', '". ($priority_cnt[0] + 1) . "','" . $created_date."')";
			$this->QUERY = "INSERT INTO " . TOPICS . " (title, description, image,priority, created_date, user_id) VALUES('" . $this->TITLE . "', '" . $this->DESCRIPTION . "', '" . $this->IMAGE . "', '" . (1) . "','" . $created_date . "','" . $this->USER . "')";

			$res_sql = mysql_query($this->QUERY) or die("INVALID QUERY" . mysql_error());
			$allow = true;
		} else {
			$allow = false;
		}
		return $allow;
	} */

	function get_alltopics($limit=null) {
		$result = mysql_query("select topics_id,title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date from " . TOPICS . ' ORDER BY topics_id DESC  limit ' . $limit) or die(mysql_error());
		return $result;
	}

	function get_allthetopics() {
		$this->QUERY = "SELECT 
							topics_id
							,title
							,CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END as description 
							,image
							,created_date  
						FROM " . TOPICS . " WHERE is_active=1 ORDER BY topics_id DESC";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsCount() {
		$sql = mysql_query("select COUNT(*) from " . TOPICS . $condition) or die(mysql_error());
		$row = mysql_fetch_array($sql);
		$total = $row[0];
		return $total;
	}

	function get_topicsById($topicsid) {
		$this->QUERY = "SELECT topics_id, title, title AS topic, description, image, CAST(is_active AS unsigned int) AS is_active, CAST(priority AS unsigned int) AS priority FROM " . TOPICS . " WHERE topics_id=" . $topicsid;
		$result = mysql_query($this->QUERY) or die(mysql_error());
		return $result;
	}

	function get_topicsByPriority() {
		$this->QUERY = "SELECT topics_id, title, priority FROM " . TOPICS . " ORDER BY priority";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function fillTopicPriorityForUser($userid="") {
		$rs_topics = $this->get_topicsByPriority();
		$i = 1;
		while ($row = mysql_fetch_array($rs_topics)) {
			$this->QUERY = "INSERT INTO tbl_topic_order 
									(user_id, topic_id,  priority_order)
								VALUES ('" . $userid . "','" . $row['topics_id'] .  "', '" . $i ."')";
			mysql_query($this->QUERY); 
			$i++;
		}
	}

	function get_topicsByPriorityOrder($count="", $userid="") {
		$endQRY = "";
		if($userid=="") {
			$this->QUERY = "SELECT 
							tp.topics_id, 
							tp.title,
							tp.user_id,
							tp.priority, 
							CASE WHEN LENGTH(tp.description) > 30 THEN CONCAT(substr(tp.description, 1, 30) , '...' )  ELSE tp.description END AS descrip, 
							tp.image, 
							tp.created_date ,
							tp.image_id,
							img.image_name,
							img.igallery_id,
							igl.igallery_name
						FROM " . TOPICS . " AS tp 
						LEFT JOIN " . IMAGES . " AS img ON (img.image_id = tp.image_id)
						LEFT JOIN " . IGALLERY . " AS igl ON (igl.igallery_id = img.igallery_id)
						 ORDER BY tp.priority ASC ";
		}else {
			$this->QUERY = "SELECT 
							tp.topics_id, 
							tp.title,
							tp.user_id,
							tp.priority, 
							CASE WHEN LENGTH(tp.description) > 30 THEN CONCAT(substr(tp.description, 1, 30) , '...' )  ELSE tp.description END AS descrip, 
							tp.image, 
							tp.created_date ,
							tp.image_id,
							img.image_name,
							img.igallery_id,
							igl.igallery_name,
							tpo.priority_order
						FROM " . TOPICS . " AS tp 
						LEFT JOIN " . IMAGES . " AS img ON (img.image_id = tp.image_id)
						LEFT JOIN " . IGALLERY . " AS igl ON (igl.igallery_id = img.igallery_id)
						LEFT JOIN tbl_topic_order AS tpo ON (tpo.topic_id = tp.topics_id) 
						WHERE tpo.user_id = $userid 
						ORDER BY tpo.priority_order ASC "; 
		}
		
		$result = mysql_query($this->QUERY);
		
		$recCnt = mysql_num_rows($result);
		if($recCnt < 1) {
			$this->fillTopicPriorityForUser($userid);
			$result = $this->get_topicsByPriorityOrder($count, $userid);
		}
		
		return $result;
	}
	
	
	function getTopicsByPriorityOrderByUser($user_id="0") {
		
//		$where = "";
//		if($user_id != "0") {
//			$where = " WHERE user_id = $user_id ";
//		}
		/*
		$this->QUERY = "SELECT 
							topics_id, 
							title, 
							priority, 
							CASE WHEN LENGTH( description ) >30 THEN CONCAT( substr( description, 1, 30 ) , '...' )  ELSE description END as descrip , 
							image, 
							created_date ,
							user_id
						FROM " . TOPICS . " $where ORDER BY priority $limit ";
		*/
		$this->QUERY = "SELECT 
						TP.topics_id, 
						TP.title, 
						TP.priority, 
						TP.user_id,
						TPO.priority_order
					FROM tbl_topics AS TP
						LEFT JOIN tbl_topic_order AS TPO ON(TPO.topic_id = TP.topics_id)
					WHERE TP.user_id = $user_id AND TPO.user_id = $user_id
					ORDER BY TPO.priority_order";
		
		$result = mysql_query($this->QUERY);
		return $result;
	}
	
	function reorderTopicsByUser($user_id="0", $order="") {
		if($order != "") {
			$lstItem = explode(',', $order);
			if(count($lstItem) > 0) {
				foreach ($lstItem as $position => $topicid) :
					$this->QUERY = " UPDATE " . TOPIC_ORDER . "  
									SET
										priority_order = ($position + 1) 
									WHERE
										user_id = '$user_id' AND topic_id = '$topicid' ";
					mysql_query($this->QUERY);
				endforeach;
				
				$this->QUERY = "SELECT MAX(TPO.priority_order) AS porder 
								FROM 
									tbl_topic_order AS TPO
								WHERE 
									TPO.user_id = $user_id
									AND TPO.topic_id IN (
												SELECT TP.topicS_id 
												FROM tbl_topics AS TP
												WHERE TP.user_id = $user_id
											)";
				$res = mysql_query($this->QUERY);
				$max_porder = mysql_fetch_array($res);
				$this->QUERY = " SELECT TPO.priority_id AS prtid, TPO.priority_order
									FROM 
										tbl_topic_order AS TPO
									WHERE 
										TPO.user_id = $user_id
										AND TPO.topic_id NOT IN (
												SELECT TP.topics_id
												FROM tbl_topics AS TP
												WHERE TP.user_id = $user_id) ORDER BY TPO.priority_order ASC ";
				
				$rs_pid = mysql_query($this->QUERY);
				$i = 1;
				$max = $max_porder['porder']; 
				while ($row = mysql_fetch_array($rs_pid)) {
					$this->QUERY = " UPDATE tbl_topic_order   
									SET priority_order = ($max + $i) 
									WHERE priority_id = " . $row ['prtid'];
					
					mysql_query($this->QUERY);
					$i++;
				}
				
			}
		}
	}

	function update_topics($topicsid, $isactive, $priority) {
		if ($priority == 0) {
			$priority = 0;
		}
		$this->QUERY = "UPDATE " . TOPICS . " SET title = '" . $this->TITLE . "', description = '" . $this->DESCRIPTION . "', image = '" . $this->IMAGE . "', is_active=" . $isactive . ", priority=" . $priority . " WHERE topics_id = " . $topicsid . "";
		
		$res_sql = mysql_query($this->QUERY) or die("INVALID QUERY" . mysql_error());
		$allow = true;
		return $allow;
	}

	function delete_topics($topicsid) {
		$this->QUERY = "DELETE FROM " . TOPICS . " WHERE topics_id = " . $topicsid . "";
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
}
?>
