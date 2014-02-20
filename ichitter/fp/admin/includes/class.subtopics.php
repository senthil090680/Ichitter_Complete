<?php
class subtopics {

	var $TOPICS_ID;
	var $TITLE;
	var $DESC;
	var $IMAGE;
	private $QUERY;
	//private $LOG;
	
	function __construct() {
		//global $logs;
		$this->TOPICS_ID = "";
		$this->TITLE = "";
		$this->DESC = "";
		$this->IMAGE = "";
		$this->QUERY = "";
		//$this->LOG = $logs;
	}

	function get_topics($title, $description, $image, $topics_id) {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
		$this->TOPICS_ID = $topics_id;
	}

	function incSubTopicPriority() {
		$this->QUERY = "UPDATE tbl_sub_topics SET priority = (priority + 1) WHERE topic_id = " . $this->TOPICS_ID;
		mysql_query($this->QUERY);
	}

	function insert_topics() {
		$allow = false;
		$created_date = date("Y-m-d");
		$this->incSubTopicPriority();
		$this->QUERY = "SELECT max( priority ) from " . SUB_TOPICS;
		$priority = mysql_query($this->QUERY);
		$priority_cnt = mysql_fetch_array($priority);

		$this->QUERY = "select * from " . SUB_TOPICS . " WHERE title ='" . $this->TITLE . "' ";
		$res = mysql_query($this->QUERY);

		if (mysql_num_rows($res) == 0) {
			$this->QUERY = "INSERT INTO " . SUB_TOPICS . " (topic_id,title, description, image,priority, created_date, is_archieved) VALUES('" . $this->TOPICS_ID . "','" . $this->TITLE . "', '" . $this->DESCRIPTION . "', '" . $this->IMAGE . "', '" . (1) . "','" . $created_date . "','')";
			$res_sql = mysql_query($this->QUERY);
			$allow = true;
		}

		return $allow;
	}

	function get_alltopics($limit=null) {
		$limitation = "";
		if(($limit != "") && (isset($limit))) {
			$limitation .= " limit " . $limit;
		}
		/*$this->QUERY = "SELECT 
							sub_topic_id, 
							topic_id, 
							title, 
							CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END, 
							image, 
							created_date 
						FROM " . SUB_TOPICS . " 
						ORDER BY sub_topic_id DESC " . $limitation; */
		
		$this->QUERY = "SELECT 
							tst.sub_topic_id, 
							tst.topic_id, 
							tst.title, 
							CASE 
								WHEN LENGTH(tst.description) > 30 THEN 
									CONCAT(substr(tst.description, 1, 30 ), '...' ) 
								ELSE 
									tst.description 
							END AS description, 
							tst.image, 
							tst.created_date,
							tt.title AS topictitle
						FROM tbl_sub_topics AS tst 
						LEFT JOIN tbl_topics AS tt ON(tt.topics_id = tst.topic_id)
						ORDER BY sub_topic_id DESC $limitation";
		
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_allSubtopics($limit='0', $topicsid='0') {
		if ($limit == 0) {
			$this->QUERY = "SELECT sub_topic_id, topic_id, title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ), '...' ) ELSE description END, image, created_date FROM " . SUB_TOPICS . ' WHERE topic_id=' . $topicsid;
		} else {
			$this->QUERY = "SELECT sub_topic_id, topic_id, title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ), '...' ) ELSE description END, image, created_date FROM " . SUB_TOPICS . ' WHERE topic_id=' . $topicsid . ' LIMIT ' . $limit;
		}
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_allthetopics() {
		$this->QUERY = "select sub_topic_id,topic_id,title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date from " . SUB_TOPICS;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsCount() {
		$this->QUERY = "select COUNT(*) from " . SUB_TOPICS;
		$sql = mysql_query($this->QUERY);
		$row = mysql_fetch_array($sql);
		$total = $row[0];
		return $total;
	}

	function get_topicsByPriority($topicid) {
		$this->QUERY = "select sub_topic_id,topic_id,title,priority from " . SUB_TOPICS . " where topic_id=" . $topicid . " order by priority";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsByPriorityOrder($count, $topicsid) {
		$this->QUERY = "SELECT sub_topic_id,topic_id, title, CASE WHEN LENGTH( description ) >30 THEN CONCAT( substr( description, 1, 30 ) , '...' )  ELSE description END  AS descr , image, created_date,priority FROM " . SUB_TOPICS . " where topic_id=" . $topicsid . " ORDER BY priority LIMIT " . $count;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsById($subtopicsid) {
		$this->QUERY = "select sub_topic_id,topic_id,title, description, image, CAST(is_active AS unsigned int) as is_active,CAST(priority AS unsigned int) as priority from " . SUB_TOPICS . " where sub_topic_id=" . $subtopicsid;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function update_topics($subtopicid, $isactive, $priority) {
		$this->QUERY = "UPDATE " . SUB_TOPICS . " SET topic_id='" . $this->TOPICS_ID . "', title = '" . $this->TITLE . "', description = '" . $this->DESCRIPTION . "', image = '" . $this->IMAGE . "', is_active=" . $isactive . ", priority='" . $priority . "' WHERE sub_topic_id = " . $subtopicid;
		$res_sql = mysql_query($this->QUERY);
		$allow = true;
		return $allow;
	}

	function delete_topics($subtopicsid) {
		$this->QUERY = "DELETE FROM " . SUB_TOPICS . " WHERE sub_topic_id = " . $subtopicsid;
		$res_sql = mysql_query($this->QUERY);
		$allow = true;
		return $allow;
	}

	function getSubTopicById($sub_topic_id) {
		$this->QUERY = "SELECT sub_topic_id, topic_id, title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date from " . SUB_TOPICS . ' where sub_topic_id = ' . $sub_topic_id;
		$result = mysql_query($this->QUERY);
		return $result;
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