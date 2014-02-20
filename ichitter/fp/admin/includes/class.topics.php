<?php
class topics {
	var $TITLE;
	var $DESC;
	var $IMAGE;
	private $QUERY;
	
	function __construct() {
		$this->TITLE = "";
		$this->DESC = "";
		$this->IMAGE = "";
		$this->QUERY = "";
	}

	function get_topics($title, $description, $image) {
		$this->TITLE = $title;
		$this->DESCRIPTION = $description;
		$this->IMAGE = $image;
	}

	function incTopicPriority() {
		$this->QUERY = "UPDATE tbl_topics SET priority = (priority + 1)";
		mysql_query($this->QUERY);
	}

	function insert_topics() {
		$allow = false;
		$created_date = date("Y-m-d");
		$this->incTopicPriority();
		$this->QUERY = "SELECT max( priority ) from " . TOPICS;
		$priority = mysql_query($this->QUERY);
		$priority_cnt = mysql_fetch_array($priority);
		
		$this->QUERY = "select * from " . TOPICS . " WHERE title ='" . $this->TITLE . "' ";
		$res = mysql_query($this->QUERY);

		if (mysql_num_rows($res) == 0) {
			$this->QUERY = "INSERT INTO " . TOPICS . " (title, description, image,priority, created_date) VALUES('" . $this->TITLE . "', '" . $this->DESCRIPTION . "', '" . $this->IMAGE . "', '" . (1) . "','" . $created_date . "')";
			$res_sql = mysql_query($this->QUERY);
			$allow = true;
		}
		
		return $allow;
	}

	function get_alltopics($limit = null) {
		$limitation = "";
		if(!empty($limit) && isset($limit)) {
			$limitation .= " LIMIT $limit ";
		}
		
		$this->QUERY = " SELECT 
							topics_id,
							title, 
							CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ), '...' ) ELSE description END as description, 
							image, 
							created_date 
						FROM " . TOPICS . " ORDER BY topics_id DESC $limitation ";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_allthetopics() {
		$this->QUERY = "select topics_id,title, CASE WHEN LENGTH(description) >30 THEN CONCAT(substr(description, 1, 30 ) , '...' ) ELSE description END , image, created_date from " . TOPICS . " where is_active=1 ORDER BY topics_id DESC";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsCount() {
		$this->QUERY = "select COUNT(*) from " . TOPICS;
		$sql = mysql_query($this->QUERY);
		$row = mysql_fetch_array($sql);
		$total = $row[0];
		return $total;
	}

	function get_topicsById($topicsid) {
		$this->QUERY = "select topics_id,title, description, image, CAST(is_active AS unsigned int) as is_active,CAST(priority AS unsigned int) as priority from " . TOPICS . " where topics_id=" . $topicsid . " ";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsByPriority() {
		$this->QUERY = "select topics_id,title,priority from " . TOPICS . " order by priority";
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function get_topicsByPriorityOrder($count) {
		$this->QUERY = "SELECT topics_id, title, priority, CASE WHEN LENGTH( description ) >30 THEN CONCAT( substr( description, 1, 30 ) , '...' )  ELSE description END , image, created_date FROM " . TOPICS . " ORDER BY priority LIMIT " . $count;
		$result = mysql_query($this->QUERY);
		return $result;
	}

	function update_topics($topicsid, $isactive, $priority) {
		if ($priority == 0) {
			$priority = 0;
		}
		$this->QUERY = "UPDATE " . TOPICS . " SET title = '" . $this->TITLE . "', description = '" . $this->DESCRIPTION . "', image = '" . $this->IMAGE . "', is_active=" . $isactive . ", priority=" . $priority . " WHERE topics_id = " . $topicsid . "";
		$res_sql = mysql_query($this->QUERY);
		$allow = true;
		return $allow;
	}

	function delete_topics($topicsid) {
		$this->QUERY = "DELETE FROM " . TOPICS . " WHERE topics_id = " . $topicsid . "";
		$res_sql = mysql_query($this->QUERY);
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