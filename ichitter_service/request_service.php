<?php
	require_once "includes/dbobj.php";
	require_once "includes/configuration.php";
	require_once 'includes/class.commonGeneric.php';
	require_once 'includes/class.request.php';
	
	$request_obj = new Request;
	
	
$action = $_REQUEST[PARAM_ACTION];

$return = array();

switch (trim($action)) {
	case 'get_all_request':
		$return = $request_obj->get_all_request($_REQUEST);
		break;
	
	case 'get_all_requestdetails':
		$return = $request_obj->get_all_requestdetails($_REQUEST);
		break;

	case 'get_req_status':
		$return = $request_obj->get_req_status($_REQUEST);
		break;

	case 'get_deny_status':
		$return = $request_obj->get_deny_status($_REQUEST);
		break;

	default:
		break;
}

print $return;
?>