<?php
require_once 'lib/include_files.php';

$user_id = $_REQUEST['user_id'];
$group_id = $_REQUEST['group_id'];
$chatText = $_POST['chatText'];		
$insertchat = $_POST['insertchat'];
$get_chats = $_REQUEST['get_chats'];
$get_updchat = $_REQUEST['get_updchat'];
$get_usrupdchat = $_REQUEST['get_usrupdchat'];
$get_grpincomming_chats = $_REQUEST['get_grpincomming_chats'];
$get_incomming_chats = $_REQUEST['get_incomming_chats'];
$get_updincomming_chats = $_REQUEST['get_updincomming_chats'];
$click_get_chats = $_POST['click_get_chats'];
$get_group_name = $_GET['get_group_name'];
$open_cookie_chats = $_POST['open_cookie_chats'];
$get_user_group_status = $_GET['get_user_group_status'];

if(isset($insertchat)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'chatText' => $chatText, 'insertchat' => 'insertchat');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;	
}
if(isset($get_chats)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'get_chats' => 'get_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;	
}
if(isset($get_updchat)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'get_updchat' => 'get_updchat');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($get_usrupdchat)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'get_usrupdchat' => 'get_usrupdchat');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($get_incomming_chats)){
	$curl_data = array('user_id' => $user_id, 'get_incomming_chats' => 'get_incomming_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($get_grpincomming_chats)){
	$curl_data = array('user_id' => $user_id, 'get_grpincomming_chats' => 'get_grpincomming_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($get_updincomming_chats)){
	$curl_data = array('user_id' => $user_id, 'get_updincomming_chats' => 'get_updincomming_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($click_get_chats)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'click_get_chats' => 'click_get_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($get_group_name)){
	$curl_data = array('group_id' => $group_id, 'get_group_name' => 'get_group_name');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
if(isset($open_cookie_chats)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'open_cookie_chats' => 'open_cookie_chats');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}

if(isset($get_user_group_status)){
	$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'get_user_group_status' => 'get_user_group_status');
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
	session_start();
	echo $res = $curl_call->response;
}
?>