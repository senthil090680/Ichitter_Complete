<?php
	require_once "includes/dbobj.php";
	require_once "includes/configuration.php";
	require_once 'includes/class.commonGeneric.php';
	require_once 'includes/class.group_service.php';
	
	$gservice_obj = new group_service;
	$action = $_REQUEST[PARAM_ACTION];

	$return = array();
	require_once 'includes/authentication.php';
if ($valid == 1) {
	switch($action){
		case 'get_group_contact':
			$return = $gservice_obj->get_group_contact($_REQUEST);
		break;
		case 'get_search_contact':
			//$return = array('test');
			$return = $gservice_obj->get_search_contact($_REQUEST);
		break;
		case 'addfriend':
			$return = $gservice_obj->add_friend_request($_REQUEST);
		break;
		case 'confirmfriend':
			$return = $gservice_obj->confirmfriend($_REQUEST);;
		break;
	}
	
	
	if(isset($_REQUEST['get_innercircle_group_ids'])){
		$return = $gservice_obj->get_innercircle_group_ids($_REQUEST['user_id']);
	}
	
	} else {
	$return = $usrprofile_obj->encode($_REQUEST);
    $return = $usrprofile_obj->encode(array("result" => "unauth", "rec" => array()));
}
	
	print $return;
?>