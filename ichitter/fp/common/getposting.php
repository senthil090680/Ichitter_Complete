<?php
$REQ_SEND[PARAM_ACTION] = "listpost";
$REQ_SEND[PARAM_POSTID] = "$postid";
$REQ_SEND[PARAM_TOPICID] = "$topicsid";
$REQ_SEND[PARAM_SUBTOPICID] = "$subtopicid";
$REQ_SEND[PARAM_USERID] = "$usid";
$REQ_SEND[PARAM_ORDER] = "DESC";
$REQ_SEND[PARAM_LIMIT] = "";
$REQ_SEND[PARAM_IS_MARKED] = false;

if($page_info['basename'] ==  "subtopics.php") {
	$REQ_SEND[PARAM_LIMIT] = "5";
}

if($page_info['basename'] ==  "viewpostings.php") {
	//$REQ_SEND[PARAM_IS_MARKED] = true;
	if(isset ($_REQUEST[PARAM_USERID])){
		$REQ_SEND['foruser'] = $_REQUEST[PARAM_USERID];
	}
}

if($page_info['basename'] ==  "markedlist.php") {
	$REQ_SEND[PARAM_IS_MARKED] = true;
	$REQ_SEND[PARAM_POSTID] = "";
	$REQ_SEND[PARAM_TOPICID] = "";
	$REQ_SEND[PARAM_SUBTOPICID] = "";
}

$REQ_SEND[PARAM_IS_ARCHIVED] = "0";

//var_dump($REQ_SEND);
$result = array();
$ObjCURL = new INIT_PROCESS(POSTING_SERVICE_PAGE, $REQ_SEND);
$result = Object2Array($ObjJSON->decode($ObjCURL->response));

$topicTitle = "";
$subTopicTitle = "";
$num_rows = count($result);
if($num_rows > 0) {
	$topicTitle = $result[0]['topic'];
    $subTopicTitle = $result[0]['subtopic'];
} elseif ( $topicsid != "" && $subtopicid == ""){
	$REQ_SEND[PARAM_ACTION] = "gettopictitle";
    $ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
    $result = array();
    $result = Object2Array($ObjJSON->decode($ObjCURL->response));
	$topicTitle = $result[0]['topic'];
    $subTopicTitle = "";
}elseif ( $topicsid != "" && $subtopicid != ""){
	$REQ_SEND[PARAM_ACTION] = "gettitles";
    $ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
    $result = array();
    $result = Object2Array($ObjJSON->decode($ObjCURL->response));
    $topicTitle = "";
    $subTopicTitle = $result[0]['subtopic'];
}
?>