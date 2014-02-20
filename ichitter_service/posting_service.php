<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
require_once "includes/configuration.php";
require_once "includes/parameters.php";
require_once "includes/class.commonGeneric.php";
require_once "includes/Logging.php";
require_once 'includes/class.discussion.php';
require_once 'includes/class.posting.php';
require_once 'includes/class.marked.php';

$ObjJSON = new Services_JSON();

$action = $_REQUEST[PARAM_ACTION];

$post_id = "";
$topic_id = "";
$sub_topic_id = "";
$user_id = "";
$Order = "";
$limit = "";
$is_archived = "";
$foruser = "";

if(isset ($_REQUEST[PARAM_POSTID])){
	$post_id = $_REQUEST[PARAM_POSTID];
}
if(isset ($_REQUEST[PARAM_TOPICID])){
	$topic_id = $_REQUEST[PARAM_TOPICID];
}
if(isset ($_REQUEST[PARAM_SUBTOPICID])){
	$sub_topic_id = $_REQUEST[PARAM_SUBTOPICID];
}
if(isset ($_REQUEST[PARAM_USERID])){
	$user_id = $_REQUEST[PARAM_USERID];
}
if(isset ($_REQUEST[PARAM_ORDER])){
	$Order = $_REQUEST[PARAM_ORDER];
}
if(isset ($_REQUEST[PARAM_LIMIT])){
	$limit = $_REQUEST[PARAM_LIMIT];
}
if(isset ($_REQUEST[PARAM_IS_ARCHIVED])){
	$is_archived = $_REQUEST[PARAM_IS_ARCHIVED];
}

if(isset ($_REQUEST['foruser'])){
	$foruser = $_REQUEST['foruser'];
}

$posting = new postings(); 
$marked = new Marked();

require_once 'includes/authentication.php';

$return = array();
switch ($action) {
	case "listpost" :
		$ismarked = $_REQUEST[PARAM_IS_MARKED];
		$result = $posting->getPostingsByID($post_id, $topic_id, $sub_topic_id, $user_id, $Order, $limit, $is_archived, $ismarked, $foruser);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$row['post_content'] = stripcslashes($row['post_content']);
			$row['title'] = stripcslashes($row['title']);
			$row['posttitle'] = stripcslashes($row['posttitle']);
			$row['content'] = stripcslashes($row['content']);
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "getuserposts" :
		$result = $posting->getUserPosts($user_id, $Order, $limit);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$row['posttitle'] = stripcslashes($row['posttitle']);
			$row['ic_content'] = stripcslashes($row['ic_content']);
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "geticposts" :
		$ismarked = $_REQUEST[PARAM_IS_MARKED];
		$sort = $_REQUEST[PARAM_SORT_ORDER];
		$iauthor = (isset($_REQUEST['iauthor']))?$_REQUEST['iauthor']:"";
		$others = "";
		$others = (isset($_REQUEST["PARAM_OTHERS"]))? $_REQUEST["PARAM_OTHERS"] : "";
		$MY_RECENTS = (isset($_REQUEST["MY_RECENTS"]))? $_REQUEST["MY_RECENTS"] : "";
		$result = $posting->get_icPostings($user_id, $ismarked, $Order, $limit, $sort, $iauthor, $MY_RECENTS);
		$i = 0;
		if($others == "othersgt") {
			while ($row = mysql_fetch_assoc($result)) {
				if($row['others'] > 0) {
					$row['post_content'] = stripcslashes($row['post_content']);
					$row['title'] = stripcslashes($row['title']);
					$row['posttitle'] = stripcslashes($row['posttitle']);
					$row['ic_content'] = stripcslashes($row['ic_content']);
					$row['content'] = stripcslashes($row['content']);
					$return[$i] = $row;
					$i++;
				}
			}
		} else {
			while ($row = mysql_fetch_assoc($result)) {
				$row['post_content'] = stripcslashes($row['post_content']);
				$row['title'] = stripcslashes($row['title']);
				$row['posttitle'] = stripcslashes($row['posttitle']);
				$row['ic_content'] = stripcslashes($row['ic_content']);
				$row['content'] = stripcslashes($row['content']);
				$return[$i] = $row;
				$i++;
			}
		}
		break;
		
	case "geticdiscussion" :
		$ismarked = $_REQUEST[PARAM_IS_MARKED];
		$sort = $_REQUEST[PARAM_SORT_ORDER];
		$others = "";
		$others = (isset($_REQUEST["PARAM_OTHERS"]))? $_REQUEST["PARAM_OTHERS"] : "";
		$result = $posting->get_icPostDiscussions($user_id, $ismarked, $Order, $limit, $sort);
		$i = 0;
		
		if($others == "minegt") {
			while ($row = mysql_fetch_assoc($result)) {
				if($row['mine'] > 0) {
					$row['post_content'] = stripcslashes($row['post_content']);
					$row['title'] = stripcslashes($row['title']);
					$row['posttitle'] = stripcslashes($row['posttitle']);
					$row['ic_content'] = stripcslashes($row['ic_content']);
					$row['content'] = stripcslashes($row['content']);
					$return[$i] = $row;
					$i++;
				}
			}
		} else {
			while ($row = mysql_fetch_assoc($result)) {
				$row['post_content'] = stripcslashes($row['post_content']);
				$row['title'] = stripcslashes($row['title']);
				$row['posttitle'] = stripcslashes($row['posttitle']);
				$row['ic_content'] = stripcslashes($row['ic_content']);
				$row['content'] = stripcslashes($row['content']);
				$return[$i] = $row;
				$i++;
			}
		}
		
		break;
		
	case "setrecent":
		$result = $posting->setRecentlyViewed($post_id, $user_id);
		if ($result) {
			$return = array("msg" => "changed");
		} else {
			$return = array("msg" => "notchanged");
		}
		break;
		
	case "getrecentposts" :
		$result = $posting->getRecentPostings($user_id);
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;
		
	case "getmostpopular" :
		$result = $posting->getMostPopularPostings();
		$i = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$return[$i] = $row;
			$i++;
		}
		break;	

	case "AddPost" :
//		if($valid == 1) {
			$sub_topic_id = $_REQUEST[PARAM_LIST_SUBTOPIC];
			$title = $_REQUEST[PARAM_POST_TITLE];
			$post_cont = nl2br($_REQUEST[PARAM_POST_CONTENT]);
			$graphic_type = $_REQUEST[PARAM_GRAPHIC_TYPE];
			if ($graphic_type == 'I') {
				$image_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
				$video_id = 0;
			} else {
				$image_id = 0;
				$video_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
			}

			$posted_on = date("Y-m-d H:i:s");
			$is_active = '0';
			$is_archived = '0';
			$result = $posting->insertPosting($topic_id, $sub_topic_id, $user_id, $title, $post_cont, $graphic_type, $image_id, 0, $video_id, 0, $posted_on, $is_active, $is_archived);
			if ($result) {
				$return = array("msg" => "post_add_success");
			} else {
				$return = array("msg" => "post_add_fail");
			}
//		} else {
//			$return = array("msg" => "unauth", "rec" => array());
//		}
		break;
		
	case "addnewposting" :
//		if($valid == 1) {
		
			$topic_id = $_REQUEST[PARAM_TOPICID];
			$sub_topic_id = $_REQUEST[PARAM_SUBTOPICID];
			$title = $_REQUEST[PARAM_POST_TITLE];
			$post_cont = nl2br($_REQUEST[PARAM_POST_CONTENT]);
			$graphic_type = $_REQUEST[PARAM_GRAPHIC_TYPE];
			$_REQUEST[PARAM_GRAPHIC_ID];
			$image_id = 0;
			$video_id = 0;
			if ($graphic_type == 'I') {
				$image_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
				$video_id = 0;
			} else {
				$image_id = 0;
				$video_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
			}

			$posted_on = date("Y-m-d H:i:s");
			$is_active = '0';
			$is_archived = '0';
			$result = $posting->insNewPosting($topic_id, $sub_topic_id, $user_id, $title, $post_cont, $graphic_type, $image_id, 0, $video_id, 0, $posted_on, $is_active, $is_archived);
			if(count($result) > 0) {
				$return = array("msg" => "post_add_success", "tid" => $result['topic_id'], "sid" => $result['sub_topic_id'], "pid" => $result['posting_id']); 
			} else {
				$return = array("msg" => "post_add_fail");
			}
			
//			if ($result) {
//				$return = array("msg" => "post_add_success");
//			} else {
//				
//			}
//		} else {
//			$return = array("msg" => "unauth", "rec" => array());
//		}
		break;
		
	case "Update":
//		if($valid == 1) {
			$title = $_REQUEST[PARAM_POST_TITLE];
			$post_cont = nl2br($_REQUEST[PARAM_POST_CONTENT]);
			$graphic_type = $_REQUEST[PARAM_GRAPHIC_TYPE];

			if ($graphic_type == 'I') {
				$image_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
				$video_id = 0;
			} else {
				$image_id = 0;
				$video_id = ($_REQUEST[PARAM_GRAPHIC_ID] == "") ? 0 : $_REQUEST[PARAM_GRAPHIC_ID];
			}

			$posted_on = date("Y-m-d H:i:s");
			$is_active = '0';
			$is_archived = '0';
			$result = $posting->updatePosting($post_id, $topic_id, $sub_topic_id, $user_id, $title, $post_cont, $graphic_type, $image_id, 0, $video_id, 0, $posted_on, $is_active, $is_archived);
			if ($result) {
				$return = array("msg" => "post_edit_success");
			} else {
				$return = array("msg" => "post_edit_fail");
			}
//		} else {
//			$return = array("msg" => "unauth", "rec" => array());
//		}
		break;

	case "delete":
		$result = $posting->deletePosting($post_id);
		if ($result) {
			$return = array("msg" => "delete_post_success");
		} else {
			$return = array("msg" => "post_delete_fail");
		}
		break;
		
	case "delPost":
		$result = $posting->deletePosting($post_id);
		if ($result) {
			$return = array("msg" => "post_delete_success", "result" => "true");
		} else {
			$return = array("msg" => "post_delete_fail", "result" => "false");
		}
		break;


	case "markpost":
		$marked_on = date("Y-m-d H:i:s");
		$postid = $_REQUEST['cb_mark1'];
		$allpost = $_REQUEST['cb_mark1'];
		$is_active = '0';
		$is_archived = '0';
		foreach ($allpost as $key => $value) {
			$vArr = explode('_', $value);
			$post_id = $vArr[0];
			$sub_topic_id = $vArr[1];
			if (in_array($post_id, $cb_mark)) {
				$oMarked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
				$result = $oMarked->insertMarked($post_id, $sub_topic_id, $user_id, $marked_on, $is_active, $is_archived);
			} else {
				$oMarked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
			}
		}
		if ($result) {
			$return = array("msg" => "mark_post_success");
		} else {
			$return = array("msg" => "mark_post_fail");
		}
		break;
		
	case "mark":
		$marked_on = date("Y-m-d H:i:s");
		$allpost = $_REQUEST['cb_mark1'];
		$pg = $_REQUEST["pg"];
		$is_active = '0';
		$is_archived = '0';
		foreach ($allpost as $key => $value) {
			$vArr = explode('_', $value);
			$post_id = $vArr[0];
			$sub_topic_id = $vArr[1];
			if (in_array($post_id, $cb_mark)) {
				$oMarked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
				$result = $oMarked->insertMarked($post_id, $sub_topic_id, $user_id, $marked_on, $is_active, $is_archived);
			} else {
				$oMarked->delMarkedByUser($user_id, $sub_topic_id, $post_id);
			}
		}
		if ($result) {
			$return = array("msg" => "mark_post_success");
		} else {
			$return = array("msg" => "mark_post_fail");
		}
		break;
		
	default :break;
}

print $ObjJSON->encode($return);
?>