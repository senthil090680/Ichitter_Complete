<?php
	require_once 'lib/include_files.php';
	$_REQUEST['field_name'] = 'login_flag';
	$_REQUEST['val'] = '0';
	$_REQUEST['action'] = 'confirm';
	$_REQUEST['table_name'] = 'tbl_user_profile';
	$_REQUEST['condition'] = "email = '".base64_decode($_REQUEST['email'])."'";
	
	$data = array('action'=>'get_user_record','email'=>base64_decode($_REQUEST['email']));	
	if($REQ_SEND['LGD']){
		$data += $REQ_SEND; 
	}
	$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE,$data);
		//echo $init_process_obj->response;
	$user_data = $ObjJSON->objectToArray($ObjJSON->decode($init_process_obj->response));
	
	if(isset($user_data['failure']) && $user_data['failure'] == 'OK'){
		//header('location:index.php');
		echo "<script>window.location = 'index.php'</script>";
	}

		
	
	/*$url = SERVICE_NAME.'registration_service.php';
	$result = call_Curl_function($_REQUEST,$url);
	$data = $ObjJSON->objectToArray($ObjJSON->decode($result));*/
	$_REQUEST += $REQ_SEND; 
	
	$init_process_obj = new INIT_PROCESS(REGISTRATION_SERVICE,$_REQUEST);		
	$result = (array)($ObjJSON->decode($init_process_obj->response));
	//print_r($result);
	if(isset($result['success'])){
		header('location:index.php?login_confirm=true');
	}
	
	/*function call_Curl_function($data,$url){
	//echo $url;

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

