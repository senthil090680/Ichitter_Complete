<?php
require_once('library/include_files.php');

$REQ_SEND = $REQ_SEND + $_REQUEST;

if(isset($_REQUEST['forgot_password'])){
	//echo SERVICE_NAME.'registration_service.php';
	//$result = call_Curl_function($_REQUEST, SERVICE_NAME.'registration_service.php');
	//$result = $ObjJSON->objectToArray($ObjJSON->decode($result));
	
	$ObjCURL = new INIT_PROCESS(USER_REGISTER_SERVICE_PAGE, $REQ_SEND);
    $result = $ObjJSON->objectToArray($ObjJSON->decode($ObjCURL->response));
	//die($ObjCURL->response);
	if(isset($result['success'])){
		header('location:index.php?success=forgot_success');
	}else{
		header('location:index.php?failure_forgot=forgot_fail');
	}
	
}elseif(isset($_REQUEST['login'])){	
    $ObjCURL = new INIT_PROCESS(LOGIN_SERVICE_PAGE, $REQ_SEND);
    $result = $ObjJSON->objectToArray($ObjJSON->decode($ObjCURL->response));
    
    if(isset($result['login_flag'])){
        print $ObjJSON->encode(array('success' => "NIL", "failure" => "NIL" , 'login_flag' => "OK"));
    }
    elseif(!$result['success']){		
        print $ObjJSON->encode(array('success' => "NIL", "failure" => "OK" , 'login_flag' => "NIL"));
    }
    else{
        $session_obj->set_Session($result, 'login'); 
        if($_SESSION['login']['success'] == "OK"){
            print $ObjJSON->encode(array('success' => "OK", "failure" => "NIL" , 'login_flag' => "NIL"));
        }	
    }
}
?>