<?php
require_once('lib/include_files.php');
$REQ_SEND = $_REQUEST + $REQ_SEND;
$REQ_SEND[PARAM_USER_ID] = SESS_USER_ID;
//$log = new Logging();


$init_process_obj = new INIT_PROCESS(EDITPROFILE_SERVICE,$REQ_SEND);
//$log->lwrite($init_process_obj->response);
print $init_process_obj->response;
/*
switch($_REQUEST['action']){
	case 'profile':
		$_REQUEST['user_id'] = $_SESSION['login']['user_id'];
		echo call_Curl_function($_REQUEST,EDITPROFILE_SERVICE);	
	break; 
	case 'profile_img':
		$_REQUEST['user_id'] = $_SESSION['login']['user_id'];
		echo call_Curl_function($_REQUEST,EDITPROFILE_SERVICE);	
	break;
	case 'profile_important':
		$_REQUEST['user_id'] = $_SESSION['login']['user_id'];		
		echo call_Curl_function($_REQUEST,EDITPROFILE_SERVICE);	
	break;
}



function call_Curl_function($data,$url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	$response = curl_exec($ch);	
	return $response;
}*/

?>