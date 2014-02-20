<?php
require_once('lib/include_files.php');

//error_reporting(0);

    
	if($_POST['submit']){
		$gallery_name = $_POST['galerry'];
		$user_id = $_POST['user_id'];
	}
	/*$ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
    curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'create_gallery_service.php' );
	//most importent curl assues @filed as file field
    $post_array = array(
        "gallery_name"=>$gallery_name,
		"user_id"=>$user_id,
        "upload"=>"Upload"
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
    $response = curl_exec($ch);
	//echo $response; */

	$curl_data = array(
		"gallery_name"=>$gallery_name,
		"user_id"=>$user_id,		
		"upload"=>"Upload");
	$curl_data+=$REQ_SEND;
	$curl_call = new INIT_PROCESS(CREATE_GALLERY_SERVICE, $curl_data);
	$response = $curl_call->response;
	
	//$response_decode = json_decode($response);	
	$response_decode =  $ObjJSON->decode($response);
	$successmsg = $response_decode->{'success'};
	$errormsg = $response_decode->{'error'};
	if($successmsg == "Directory has been created successfully"){
	 $path = $target_path;
	 header('Location: photos.php?msg=glrysuccess');
    //unlink($path);
	}elseif($errormsg == "Directory created already"){
	 header('Location: photos.php?msg=direxist');
	}else{
	 header('Location: photos.php?msg=cnntcrtdir');
	}	

?>