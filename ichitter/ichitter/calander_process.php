<?php
require_once('lib/include_files.php');
$REQ_SEND = $_REQUEST + $REQ_SEND;
$REQ_SEND[PARAM_USER_ID] = SESS_USER_ID;

if(!isset($REQ_SEND['action'])){
    $REQ_SEND['action'] = 'event_delete';
}
//$log = new Logging();



$init_process_obj = new INIT_PROCESS(CALANDER_SERVICE,$REQ_SEND);

print $init_process_obj->response;
?>