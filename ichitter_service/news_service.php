<?php
	require_once "includes/dbobj.php";
	require_once "includes/configuration.php";
	require_once 'includes/class.commonGeneric.php';
    require_once 'includes/class.group_service.php';
	require_once 'includes/class.news.php';
     
     $gservice_obj = new group_service;
	 $news_obj = new News();
	
	 $PARAM_ACTION = '';
$action = $_REQUEST[PARAM_ACTION];
require_once 'includes/authentication.php';
$return = array();
if($valid == 1) {
switch ($action) {
	case 'get_all_newsstreams':
		//$return = $news_obj->encode($_REQUEST);
		$user_id = $_REQUEST['user_id'];
		if($_REQUEST['user_id'] == $_REQUEST['USD']){
			$result = $gservice_obj->get_innercircle_ids($_REQUEST);			
			$return = $news_obj->get_all_newsstreams($result, $user_id);
		}else{
			$return = $news_obj->get_all_newsstreams('', $user_id);
		}
		break;
	
	case 'update_read':
		$result = $news_obj->update_read($_REQUEST);
		$return = $news_obj->encode(array('success' => $result));
		break;

	default:
		break;
}
} else {
	 $return = $usr_obj->encode($unauth);
 }

print $return;
?>