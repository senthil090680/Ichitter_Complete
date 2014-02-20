<?php
include_once("library/include_files.php");
include_once 'common/redirectto.php';

$REQ_SEND[PARAM_ACTION] = $_REQUEST[PARAM_ACTION];
$REQ_SEND['txt'] = $_REQUEST['txt'];
$ObjCURL = new INIT_PROCESS(BW_SERVICE_PAGE, $REQ_SEND);
print $ObjCURL->response;

?>
