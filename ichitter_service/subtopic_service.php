<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/parameters.php";
require_once "includes/configuration.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once 'includes/class.subtopics.php';

$ObjJSON = new Services_JSON();

$action = $_REQUEST[PARAM_ACTION];

$subtopics = new subtopics();
$return = array();
switch ($action) {
	case "bypriority" :
		$topicid = (isset($_REQUEST[PARAM_TOPICID]))? $_REQUEST[PARAM_TOPICID]: "";
		$user_id = (isset($_REQUEST[PARAM_USERID]))? $_REQUEST[PARAM_USERID]: "";
		$result = $subtopics->get_topicsByPriorityOrder('', $topicid, $user_id);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "gettitles" :
		$topicid = (isset($_REQUEST[PARAM_TOPICID]))? $_REQUEST[PARAM_TOPICID]: "";
		$subtopicid = (isset($_REQUEST[PARAM_SUBTOPICID]))? $_REQUEST[PARAM_SUBTOPICID]: "";
		
		$result = $subtopics->get_topicsTitles($topicid, $subtopicid);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "getsubtopicslist" :
		$topicid = (isset($_REQUEST[PARAM_TOPICID]))? $_REQUEST[PARAM_TOPICID]: "";
		$subtopicid = (isset($_REQUEST[PARAM_SUBTOPICID]))? $_REQUEST[PARAM_SUBTOPICID]: "";
		$result = $subtopics->get_topicsTitles($topicid, $subtopicid);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
	
	case "addsubtopic" :
		$tid = $_REQUEST[PARAM_TOPICID];
		$title = $_REQUEST[PARAM_TOPIC_TITLE];
		$desc = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
		$image_id = $_REQUEST[PARAM_GRAPHIC_ID];
		$userid = $_REQUEST[PARAM_USERID];
		
		$subtopics->set_topics($title, $desc, $fname, $tid, $userid, $image_id);
		$result = $subtopics->insert_topics();
		
		if($result) {
			$return = array("msg" => "OK", "error" => "no");
		} else {
			$return = array("msg" => "NO", "error" => "s");
		}
		
		break;
		
	case "addnewsubtopic" :
		$tid = $_REQUEST[PARAM_TOPICID];
		$title = $_REQUEST[PARAM_TOPIC_TITLE];
		$desc = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
		$fname = $_REQUEST[PARAM_FILE_NAME];
		$file_binary = base64_decode($_REQUEST[PARAM_FILE_CONTENT]);
		$userid = $_REQUEST[PARAM_USERID];
		$subtopics->set_topics($title, $desc, $fname, $tid, $userid);
		$result = $subtopics->insert_topics();
		
		if($result) {
			$cwd = getcwd();
			$movedir = $cwd . "/upload/photos/upload_image";
			if(!is_dir($movedir)){ 
				mkdir($movedir, 0777, true);
			}
			$moveto = $movedir . '/' . $fname;
	
			$handle = fopen($moveto, "wb");
			$img_contents = fwrite($handle, $file_binary);
			fclose($handle);
			$return = array("msg" => "OK", "error" => "no");
		} else {
			$return = array("msg" => "NO", "error" => "s");
		}
		
		break;
	
	case "getmax" : 
		$topicid = $_REQUEST[PARAM_TOPICID];
		$res = $subtopics->getSubTopicsCount($topicid);
		$return = array("total" => $res);
		break;
	
	case "list2order" :
		$topicid = (isset($_REQUEST[PARAM_TOPICID]))?$_REQUEST[PARAM_TOPICID]:"";
		$userid = (isset($_REQUEST[PARAM_USERID]))?$_REQUEST[PARAM_USERID]:"";
		$limit = (isset($_REQUEST[PARAM_LIMIT]))?$_REQUEST[PARAM_LIMIT]:"";
		
		$result = $subtopics->getSubTopicsByUser($topicid, $userid, $limit);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "subtopicreorder" : 
		$listItems = $_REQUEST['listItem'];
		$userid = $_REQUEST[PARAM_USERID];
		$topicid = $_REQUEST[PARAM_TOPICID];
		$subtopics->reorderSubTopicsByUser($userid, $listItems, $topicid);
		$return = array("msg" => "ok", "error" => "no");
		break;
		
	default :break;
}
//print $ObjJSON->encode(array("src"=>"$result"));
print $ObjJSON->encode($return);
?>
