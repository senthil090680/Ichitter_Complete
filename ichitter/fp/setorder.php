<?php
require_once('library/include_files.php');

$page = (isset($_REQUEST['pg']))?$_REQUEST['pg']: "";

$REQ_SEND = $REQ_SEND + $_REQUEST;
$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];

if($page == 'stpo') {
	$REQ_SEND[PARAM_ACTION] = 'cngsubtopicorder';
	$ObjCURL = new INIT_PROCESS(SUBTOPIC_SERVICE_PAGE, $REQ_SEND);
	$result = Object2Array($ObjJSON->decode($ObjCURL->response));
	
} else if($page == 'tpo') {
	$REQ_SEND[PARAM_ACTION] = 'cngtopicorder';
	$ObjCURL = new INIT_PROCESS(TOPIC_SERVICE_PAGE, $REQ_SEND);
	$result = Object2Array($ObjJSON->decode($ObjCURL->response));
}

/*
foreach ($_GET['listItem'] as $position => $item) :
	$sql[] = "UPDATE `tbl_sub_topics` SET `priority` = ($position + 1) WHERE `sub_topic_id` = $item";
endforeach;


for($i=0;$i<count($sql);$i++)
{
    mysql_query($sql[$i]);
}
*/
?>