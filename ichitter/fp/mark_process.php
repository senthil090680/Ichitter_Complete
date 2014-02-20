<?php
include_once("library/include_files.php");

if ($action == "") {
	$action = $_REQUEST[PARAM_ACTION];
}

$REQ_SEND = $REQ_SEND + $_REQUEST;

$REQ_SEND[PARAM_USERID] = $_SESSION['login']['user_id'];

if($action == "markpost") {
	$ObjCURL = new INIT_PROCESS(MARKING_SERVICE_PAGE, $REQ_SEND);
	print $ObjCURL->response;
}
?>
