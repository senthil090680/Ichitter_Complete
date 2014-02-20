<?php
require_once('lib/include_files.php');
error_reporting(0);
//print_r($_FILES);

        $user_id = $_POST['user_id'];
		$group_id = $_POST['group_id'];

		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'class.group_service.php' );
		//most importent curl assues @filed as file field
		$post_array = array(
			"user_id"=>$user_id,		
			"group_id"=>$group_id,				
			"activate_member"=>"activate_member"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
		echo $response = curl_exec($ch);*/

		$curl_data = array('user_id' => $user_id, 'group_id' => $group_id, 'activate_member' => 'activate_member' );
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(CREATE_GROUP_SERVICE, $curl_data);
		echo $res = $curl_call->response;
?>