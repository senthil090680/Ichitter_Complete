<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/parameters.php";
require_once "includes/configuration.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once "includes/class.topics.php";

$ObjJSON = new Services_JSON();
$action = $_REQUEST[PARAM_ACTION];
$topics = new topics();
//$lo = new Logging();

$userid = 0;
if(isset ($_REQUEST[PARAM_USERID])) {
	$userid = $_REQUEST[PARAM_USERID];
}
require_once 'includes/authentication.php';

$return = array();

switch (trim($action)) {
	case "bypriority" :
		$user_id = (isset($_REQUEST[PARAM_USERID]))? $_REQUEST[PARAM_USERID]: "";
		$result = $topics->get_topicsByPriorityOrder("", $user_id);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "gettopictitle" :
		$result = $topics->get_topicsById($_REQUEST[PARAM_TOPICID]);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "gettopicslist" :
		$result = $topics->get_allthetopics();
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "addnewtopic" :
//		if($valid == 1) {
			$title = $_REQUEST[PARAM_TOPIC_TITLE];
			$desc = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
			$fname = $_REQUEST[PARAM_FILE_NAME];
			$file_binary = base64_decode($_REQUEST[PARAM_FILE_CONTENT]);
			$userid = $_REQUEST[PARAM_USERID];
			$topics->set_topics($title, $desc, $fname, $userid);
			$result = $topics->insert_topics();
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
//		} else {
//			$return = array("msg" => "unauth", "rec" => array());
//		}
		break;
		
	case "addtopic" :
			$title = $_REQUEST[PARAM_TOPIC_TITLE];
			$desc = $_REQUEST[PARAM_TOPIC_DESCRIPTION];
			$image_id = $_REQUEST[PARAM_GRAPHIC_ID];
			$userid = $_REQUEST[PARAM_USERID];
			
			$topics->set_topics($title, $desc, $fname, $userid, $image_id);
			$result = $topics->insert_topics();
			
			if($result) {
				$return = array("msg" => "OK", "error" => "no");
			} else {
				$return = array("msg" => "NO", "error" => "s");
			}
		break;
		
	case "list2order" :
		$result = $topics->getTopicsByPriorityOrderByUser($userid);
		$i = 0;
	
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "topicreorder" :
		$listItems = $_REQUEST['listItem'];
		$userid = $_REQUEST[PARAM_USERID];
		$topics->reorderTopicsByUser($userid, $listItems);
		$return = array("msg" => "ok", "error" => "no");
		break;
		
	default : break;
}
print $ObjJSON->encode($return);
?>
