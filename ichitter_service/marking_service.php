<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/parameters.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once 'includes/class.marked.php';

$ObjJSON = new Services_JSON();

require_once 'includes/authentication.php';

$action = $_REQUEST[PARAM_ACTION];

$topic_id = "";
$sub_topic_id = "";
$user_id = "";

if(isset ($_REQUEST[PARAM_TOPICID])) {
	$topic_id = $_REQUEST[PARAM_TOPICID];
}

if(isset ($_REQUEST[PARAM_SUBTOPICID])) {
	$sub_topic_id = $_REQUEST[PARAM_SUBTOPICID];
}

if(isset ($_REQUEST[PARAM_USERID])) {
	$user_id = $_REQUEST[PARAM_USERID];
}

$marked = new Marked();

$return = array();
switch ($action) {
	case "markpost":
		//if($valid == 1) {
			$post_id = $_REQUEST[PARAM_POSTID];
			$marked_on = date("Y-m-d H:i:s");
			$ismarked = $_REQUEST[PARAM_IS_MARKED];
			$is_active = '0';
			$is_archived = '0';
			if($ismarked === "true") {
				$result = $marked->insertMarked($post_id, $sub_topic_id, $user_id, $marked_on, $is_active, $is_archived);
				if ($result) {
					$return = array("msg" => "mark_post_success");
				} else {
					$return = array("msg" => "mark_post_fail");
				}
			}
			else {
				$result = $marked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
				if ($result) {
					$return = array("msg" => "unmark_post_success");
				} else {
					$return = array("msg" => "unmark_post_fail");
				}
			}
		//} else {
		//	$return = array("msg" => "unauth", "rec" => array());
		//}
		break;
		
	case "markall":
		//if($valid == 1) {
			$marked_on = date("Y-m-d H:i:s");
			$cb_mark = $_REQUEST['cb_mark'];
			$cb_mark = substr($cb_mark, 0, strlen($cb_mark) - 1);
			$allpost = explode(',', $cb_mark); 
			$is_active = '0';
			$is_archived = '0';
			foreach ($allpost as $key => $value) {
				$vArr = explode('_', $value);
				$post_id = $vArr[0];
				$sub_topic_id = $vArr[1];
				$marked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
				$result = $marked->insertMarked($post_id, $sub_topic_id, $user_id, $marked_on, $is_active, $is_archived);
			}
			$return = array("msg" => "mark_post_success");
		//} else {
		//	$return = array("msg" => "unauth", "rec" => array());
		//}
		
		break;

	default :break;
}

print $ObjJSON->encode($return);
?>