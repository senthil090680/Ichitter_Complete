<?php
	require_once "includes/dbobj.php";
	require_once "includes/configuration.php";
	require_once 'includes/class.commonGeneric.php';
	require_once 'includes/class.msg.php';
	
	$msg_obj = new Msg();
	
	$action = $_REQUEST[PARAM_ACTION];
require_once 'includes/authentication.php';
	$return = array();
	if($valid == 1) {
	switch($action){
		case 'sendmsg':
		case 'replymsg':
			$return = $msg_obj->sendmsg($_REQUEST);
		break;
		case 'getall_msg':
			$return = $msg_obj->getall_msg($_REQUEST);
		break;
		case 'readmsg':
			$return = $msg_obj->readmsg($_REQUEST);
		break;
		case 'get_indivitual_msg':
			$return = $msg_obj->get_indivitual_msg($_REQUEST);
		break;
	}
	
	
	if(isset($_REQUEST['getcount_unread_msg'])){
		$return = $msg_obj->getcount_unread_msg($_REQUEST);
	}
	} else {
	 $return = $msg_obj->encode($unauth);
 }
	print $return;
	
	
?>