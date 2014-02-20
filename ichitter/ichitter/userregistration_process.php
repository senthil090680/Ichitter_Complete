<?php
error_reporting(0);
require_once('lib/include_files.php');

//print_r($_REQUEST);
	$session_obj = new SESSION();
	$action = $_REQUEST['action'];
	/*echo '<pre />';
	print_r($REQ_SEND);*/
	if($REQ_SEND['LGD']){
		$_REQUEST += $REQ_SEND; 
	}
	//print_r($_REQUEST);
	switch($action){
		case 'email_validation':
			echo call_Curl_function($_REQUEST, REGISTRATION_SERVICE);
		break;
		case 'forgot_password':
			$result = call_Curl_function($_REQUEST,REGISTRATION_SERVICE);
			$result = (array)($ObjJSON->decode($result));
			//print_r($result);
			if(isset($result['success'])){
				header('location:index.php?success=forgot_success');
			}else{
				header('location:index.php?failure_forgot=forgot_fail');
			}
		break;
		case 'change_password':
			/*echo '<pre />';
			print_r($_REQUEST);
			exit;*/
			$result = call_Curl_function($_REQUEST,REGISTRATION_SERVICE);
			$result = $ObjJSON->objectToArray($ObjJSON->decode($result));
			
			if($result['success']){
				$session_obj->unset_Session('login');
				header('location:index.php?success=PASS_RE_SET');
			}elseif($result['failure']){
				header('location:changepassword.php?failure=PASS_RE_SET_FAIL&email='.base64_encode($_REQUEST['email']));
			}
		break;
		case 'login':
			$result = call_Curl_function($_REQUEST,SERVICE_NAME.'login_service.php');	
			$result = $ObjJSON->objectToArray($ObjJSON->decode($result));
			if(isset($result['login_flag'])){
				header('location:index.php?confirm=FAIL');	
			}elseif(!$result['success']){		
				header('location:index.php?failure=OK');	
			}else{
				session_start();
				$session_obj->set_Session($result,'login'); 
			   if($_SESSION['login']['success'] == "OK"){
				   $global_user_id			= $_SESSION['login']['user_id'];
				   $_SESSION['username']	= $global_user_id;
				header('location:editprofile.php?success=OK');
			   }	
			}
		break;
		case 'user_register':	
			$json = call_Curl_function($_REQUEST, REGISTRATION_SERVICE);
			$arr = $ObjJSON->objectToArray($ObjJSON->decode($json)); 
			//if($arr['success'] == 1){				
				echo "<script>window.location = 'index.php?success=true';</script>";
			//}
		break;
	}

/* call service page*/	
function call_Curl_function($data,$url){
	$curl = new INIT_PROCESS($url, $data);
	$response = $curl->response;
	/*$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	$response = curl_exec($ch);	
	*/
	//echo $response;
	//exit;
	
	return $response;
}
	
?>