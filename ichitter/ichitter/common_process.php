<?php
require_once('lib/include_files.php');
$REQ_SEND = $_REQUEST + $REQ_SEND;
$REQ_SEND[PARAM_USER_ID] = SESS_USER_ID;
//$log = new Logging();

$init_process_obj = new INIT_PROCESS($_REQUEST['url'],$REQ_SEND);
//$log->lwrite($init_process_obj->response);

print $init_process_obj->response;

?>