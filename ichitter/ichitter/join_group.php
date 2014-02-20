<?php
require_once('lib/include_files.php');
$user_id = $_POST['user_id'];
$group_id = $_POST['group_id'];
$user_id_join = $_POST['user_id_join'];
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'class.group_service.php' );
		//most importent curl assues @filed as file field
		$post_array = array(
	
			"group_id"=>$group_id,					
			"user_id"=>$user_id,		
			"user_id_join"=>$user_id_join,				
			"join_group"=>"join"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
		$response = curl_exec($ch);
		echo $response;*/

		$curl_data = array(
			"group_id"=>$group_id,					
			"user_id"=>$user_id,		
			"user_id_join"=>$user_id_join,				
			"join_group"=>"join" );
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(CLASS_GROUP_SERVICE, $curl_data);
		echo $response = $curl_call->response;
?>