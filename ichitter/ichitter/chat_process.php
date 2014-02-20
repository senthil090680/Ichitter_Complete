<?php
require_once('lib/include_files.php');
error_reporting(0);
//print_r($_FILES);

        $user_id = $_POST['userid'];
		$group_id = $_POST['groupid'];
		$chatText = $_POST['text'];		

    	//$timestamp = time();
		//$path = dirname(__FILE__)."/".$target_path;


		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'chat_service.php' );
		//most importent curl assues @filed as file field
		$post_array = array(
			"chatText"=>$chatText,
			"user_id"=>$user_id,		
			"group_id"=>$group_id,				
			"insertchat"=>"insertchat"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
		echo $response = curl_exec($ch);*/

		$curl_data = array(
			"chatText"=>$chatText,
			"user_id"=>$user_id,		
			"group_id"=>$group_id,				
			"insertchat"=>"insertchat");
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(GRP_CHAT_SERVICE, $curl_data);
		echo $response = $curl_call->response;


	//echo $response;
		//$response_decode = json_decode($response);	
	//	$response_decode = $ObjJSON->decode($response);
		//$successmsg = $response_decode->{'success'};
?>