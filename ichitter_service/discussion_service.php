<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/parameters.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once 'includes/class.discussion.php';

$ObjJSON = new Services_JSON();

$action = (isset($_REQUEST[PARAM_ACTION]))?$_REQUEST[PARAM_ACTION]:"";
$topicid = (isset($_REQUEST[PARAM_TOPICID]))?$_REQUEST[PARAM_TOPICID]:"";
$subtopicid = (isset($_REQUEST[PARAM_SUBTOPICID]))?$_REQUEST[PARAM_SUBTOPICID]:"";
$postid = (isset($_REQUEST[PARAM_POSTID]))?$_REQUEST[PARAM_POSTID]:"";
$userid = (isset($_REQUEST[PARAM_USERID]))?$_REQUEST[PARAM_USERID]:"";
$fordiscussion = (isset($_REQUEST[PARAM_FOR_DISCUSSION]))?$_REQUEST[PARAM_FOR_DISCUSSION]:"";

$discussion = new Discussion();

$return = array("0" => array());
$result = "";
require_once 'includes/authentication.php';

switch(trim($action)) {
    case "adddisc" : 
//		if($valid == 1) {
			$content = $_REQUEST[PARAM_CONTENT];
			$result = $discussion->addNewDiscussion($topicid, $subtopicid, $postid, $userid, $fordiscussion, $content);
			$lastrow = $discussion->getLastInsertedDiscussion();
			$img = $lastrow['image'];
			$img_arr = explode('$', $img);
			$img_arrCnt = count($img_arr);
			$imgSrc = "";
			if($img_arr[0] == 'm') {
				$imgSrc = "resource/images/male-small.jpg";
			} else {
				$imgSrc = "resource/images/female-small.jpg";
			}

			if(isset($img_arr[2]) || isset($img_arr[3])) {
				$imgSrc = IMAGE_UPLOAD_SERVER;
				if(isset($img_arr[1])) {
					$imgSrc .= $lastrow['user_id'] . '/';
				}
				if(isset($img_arr[2])) {
					$imgSrc .= $img_arr[2];
					if($img_arrCnt>3) {
						$imgSrc .= '/';
					}
				}
				if(isset($img_arr[3])) {
					$imgSrc .= $img_arr[3];
				}
			}
			
			$lastrow['image'] = $imgSrc;
			if($result) {
				$return = array("result" => "OK", "rec" => $lastrow);
			} else {
				$return = array("result" => "NO", "rec" => array());
			}
//		} else {
//			$return = array("result" => "unauth", "rec" => array());
//		}
		break;
		
	case "adddiscussion" : 
//		if($valid == 1) {
			$content = $_REQUEST[PARAM_CONTENT];
			$result = $discussion->addNewDiscussion($topicid, $subtopicid, $postid, $userid, $fordiscussion, $content);
			if($result) {
				$data = $discussion->getLastInsertedDiscussion();
				$return = array("result" => "OK", "rec" => array(),'last_insert'=>$data);
			} else {
				$return = array("result" => "NO", "rec" => array());
			}
//		} else {
//			$return = array("result" => "unauth", "rec" => array());
//		}
		break;
	
	case "getcount" :
		$result = $discussion->getDiscussionCount($topicid, $subtopicid, $postid, $fordiscussion);
		$row = mysql_fetch_array($result);
		$return = array("count" => $row['cnt']);
		break;
		
	case "getdiscussionlist" :
		$result = $discussion->getDiscussions($topicid, $subtopicid, $postid, $fordiscussion);
		$i = 0;
		while ($row = mysql_fetch_array($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;

	case "discussionlist" :
		$sort = $_REQUEST[PARAM_SORT_ORDER];
		$result = $discussion->discussionList($postid, $fordiscussion, $sort);
		$return = $discussion->ARRAY;
		break;
	
	case "viewed" :
//		if($valid == 1) {
			$result = $discussion->setDiscussionViewed($userid, $fordiscussion);
			if($result) {
				$return = array("result" => "OK", "rec" => "$result");
			} else {
				$return = array("result" => "NO", "rec" => "$result");
			}
//		} else {
//			$return = array("result" => "unauth", "rec" => array());
//		}
		break;
    
	case "getichdisc" :
			$result = $discussion->get_iChitterDiscussionsByUserGroups($userid);
			$i = 0;
			while ($row = mysql_fetch_array($result)) {
				$return[$i] = $row;
				$i++;
			}
			break;
    default :break;
}

print $ObjJSON->encode($return);
?>