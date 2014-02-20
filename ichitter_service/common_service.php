<?php
	require_once "includes/dbobj.php";
	require_once "includes/configuration.php";
	require_once 'includes/class.commonGeneric.php';	
	require_once 'includes/class.request.php';
	require_once 'includes/class.msg.php';
	require_once "includes/class.news.php";
	 require_once 'includes/class.group_service.php';
	
	
	$common = new commonGeneric();   
	$msg_obj = new Msg();
	$reqs_obj = new Request();
	$news_obj = new News();
	$gservice_obj = new group_service;
	
	$action = $_REQUEST[PARAM_ACTION];
require_once 'includes/authentication.php';
	$return = array();
	if($valid == 1) {
	switch($action){
		case 'get_header_alt':
	
		$new_arr = array();
		$data = $_REQUEST;
		//print $common->encode($data);         
		$new_arr['all_request'] = $reqs_obj->get_all_request($data);		
		$new_arr['unread_msg'] = $msg_obj->getcount_unread_msg($data);
		
		$innercircle_ids = $gservice_obj->get_innercircle_ids($data);
		$new_arr['unread_news'] = $news_obj->get_unread_news_count($data,$innercircle_ids);
		
		$return = $common->encode($new_arr);
		break;
		case 'getmutual_friends':
              $new_arr = array();
              $new_arr = $common->get_mutual_friend($_REQUEST);
              $return = $common->encode($new_arr);
         break;
	}
	} else {
	 $return = $usr_obj->encode($unauth);
 }
	print $return;
		
	
	
?>