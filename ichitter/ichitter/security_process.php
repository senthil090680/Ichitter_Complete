<?php
	//print_r($_REQUEST);
	
require_once('lib/include_files.php');
$session_obj = new SESSION();

switch($_REQUEST['action']){
	case 'security_setting':		
	$_REQUEST['user_id'] = $session_obj->get_Session('user_id');
	$_REQUEST = $REQ_SEND + $_REQUEST;
	$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'security_service.php',$_REQUEST);
	print $init_process_obj->response;
	break;
}
	
	
	
?>