<?php
include_once("library/include_files.php");
include_once 'common/redirectto.php';

$action = "";
$action = $_REQUEST[PARAM_ACTION];
$currentPage = $_REQUEST[PARAM_CURRENT_PAGE];
$REQ_SEND = $REQ_SEND + $_REQUEST;
$REQ_SEND[PARAM_USERID] = $_SESSION['login']["user_id"];

$log = new Logging();

if($action == "AddPost" ) { 
	
	$REQ_SEND[PARAM_POSTID] = $_REQUEST[PARAM_POSTID];
	$REQ_SEND[PARAM_ORDER] = $_REQUEST[PARAM_ORDER];
	$REQ_SEND[PARAM_LIMIT] = $_REQUEST[PARAM_LIMIT];
	$REQ_SEND[PARAM_IS_ARCHIVED] = $_REQUEST[PARAM_IS_ARCHIVED];
	$REQ_SEND[PARAM_POST_CONTENT] = $_REQUEST[PARAM_POST_CONTENT];
	
	$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
	$jsonResponse = Object2Array($ObjJSON->decode($ObjCURL->response));
	
	$msg = $jsonResponse["msg"];
	if($currentPage == "st") {
		print "<script>window.location='subtopics.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&msg=$msg'</script>";
	} else if($currentPage == "fh") {
		print "<script>window.location='federal-history.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&msg=$msg'</script>";
	}
	
} else if($action == "addnewposting" ) { 
	//print_r($_REQUEST);
	//die;
	$REQ_SEND[PARAM_TOPICID] = $_REQUEST['st_topics'];
	$REQ_SEND[PARAM_SUBTOPICID] = $_REQUEST[PARAM_LIST_SUBTOPIC];
	$REQ_SEND[PARAM_POST_TITLE] = $_REQUEST[PARAM_POST_TITLE];
	$REQ_SEND[PARAM_POST_CONTENT] = $_REQUEST[PARAM_POST_CONTENT];
	$REQ_SEND[PARAM_GRAPHIC_TYPE] = $_REQUEST[PARAM_GRAPHIC_TYPE];
	$REQ_SEND[PARAM_GRAPHIC_ID] = $_REQUEST[PARAM_GRAPHIC_ID];
	
	$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
	$jsonResponse = Object2Array($ObjJSON->decode($ObjCURL->response));
	
	$msg = $jsonResponse["msg"];
	
	if($msg == "post_add_success") {
		print "<script>window.location='discussion.php?" . PARAM_TOPICID . "=" . $jsonResponse['tid'] . "&" . PARAM_SUBTOPICID . "=" . $jsonResponse['sid'] . "&" . PARAM_POSTID . "=" . $jsonResponse['pid'] ."&msg=$msg'</script>";
	} else {
		print "<script>window.location='add_newpost.php?msg=$msg'</script>";
	}
	
	/*(if($currentPage == "st") {
		print "<script>window.location='subtopics.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&msg=$msg'</script>";
	} else if($currentPage == "fh") {
		print "<script>window.location='federal-history.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&msg=$msg'</script>";
	}*/
	
} else if ($action == "Update" ) {
	
	$REQ_SEND[PARAM_POSTID] = $_REQUEST[PARAM_POSTID];
	$REQ_SEND[PARAM_ORDER] = $_REQUEST[PARAM_ORDER];
	$REQ_SEND[PARAM_LIMIT] = $_REQUEST[PARAM_LIMIT];
	$REQ_SEND[PARAM_IS_ARCHIVED] = $_REQUEST[PARAM_IS_ARCHIVED];
	$REQ_SEND[PARAM_POST_CONTENT] = htmlspecialchars($_REQUEST[PARAM_POST_CONTENT]);
	$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
	$jsonResponse = Object2Array($ObjJSON->decode($ObjCURL->response));
	
	$msg = $jsonResponse["msg"];
	if($currentPage == "st") {
		print "<script>window.location='subtopics.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&msg=$msg'</script>";
	} else if($currentPage == "fh") {
		print "<script>window.location='federal-history.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&msg=$msg'</script>";
	}else {
		print "<script>window.location='discussion.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&"  . PARAM_POSTID . "=" . $_REQUEST[PARAM_POSTID] . "&msg=$msg'</script>";
	}
	
} else if($action == "markall") {
	
	$REQ_SEND = $REQ_SEND + $_REQUEST;
	$arr = $_REQUEST['cb_mark'];
	$val = "";
	foreach($arr as $k => $v) {
		$val .= $v . ",";
	}
	$REQ_SEND['cb_mark'] = $val;
	$ObjCURL = new INIT_PROCESS(MARKING_SERVICE_PAGE, $REQ_SEND);
	$jsonResponse = (array)($ObjJSON->decode($ObjCURL->response));
	$msg = $jsonResponse["msg"];
	if($currentPage == "st") {
		print "<script>window.location='subtopics.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&msg=$msg'</script>";
	} else if($currentPage == "fh") {
		print "<script>window.location='federal-history.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&msg=$msg'</script>";
	}else if($currentPage == "mk") {
		print "<script>window.location='markedlist.php?" . PARAM_TOPICID . "=" . $_REQUEST[PARAM_TOPICID] . "&"  . PARAM_SUBTOPICID . "=" . $_REQUEST[PARAM_SUBTOPICID] . "&msg=$msg'</script>";
	}else {
		print "<script>window.location='alltopics.php?msg=$msg';</script>";
	}
	
} else if($action == "delPost") {
	
	$REQ_SEND[PARAM_ACTION] = $_REQUEST[PARAM_ACTION];
	$REQ_SEND[PARAM_POSTID] = $_REQUEST['pid'];
	$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
	print $ObjCURL->response;
	
} else if($action == "getsubtopicslist") {
	
	$REQ_SEND[PARAM_ACTION] = $_REQUEST[PARAM_ACTION];
	$REQ_SEND[PARAM_TOPICID] = $_REQUEST['tid'];
	$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
	print $ObjCURL->response;
}
?>