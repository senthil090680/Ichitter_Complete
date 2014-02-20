<?php
require_once('lib/include_files.php');
//print_r($_REQUEST);

if(isset($_REQUEST['email_validation']) || isset($_REQUEST['forgot_password']) ){
	echo call_Curl_function($_REQUEST,SERVICE_NAME.'registration_service.php');	
}elseif(isset($_REQUEST['change_password'])){	

	$result = call_Curl_function($_REQUEST,SERVICE_NAME.'registration_service.php');
	$result = json_decode($result,true);	
	if($result['success']){
		$session_obj->unset_Session('login');
		header('location:index.php?success=PASS_RE_SET');
	}elseif($result['failure']){
		header('location:changepassword.php?failure=PASS_RE_SET_FAIL');
	}
	
}elseif(isset($_REQUEST['login'])){	
	$result = call_Curl_function($_REQUEST,SERVICE_NAME.'login_service.php');
	$result = json_decode($result,true);
	if(!$result['success']){		
		header('location:index.php?failure=OK');	
	}else{
		$session_obj->set_Session($result,'login'); 		
		header('location:editprofile.php?success=OK');
	}
}else{
	$json = call_Curl_function($_REQUEST, SERVICE_NAME . 'registration_service.php');
	$arr = json_decode($json, true);	
	if($arr['success'] == 1){
		header('location:index.php?success=true');
	}
}

/* call service page*/	
function call_Curl_function($data,$url){
	//print_r($url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	$response = curl_exec($ch);	
	/*echo $response;
	exit;*/
	return $response;
}
	
?>