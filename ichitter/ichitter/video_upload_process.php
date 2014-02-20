<?php
require_once('lib/include_files.php');
//error_reporting(0);
$target_path = "upload/";
for($i=0;$i<count($_FILES['multiplefile']);$i++){
	$target_path = $target_path . basename( $_FILES['multiplefile']['name'][$i]); 
 if($_FILES['multiplefile']['error'][$i] == "0"){		
  if($_FILES['multiplefile']['name'][$i] != ""){	
	if(move_uploaded_file($_FILES['multiplefile']['tmp_name'][$i], $target_path)) {
        $user_id = $_POST['user_id'];
		$gallery = $_POST['gallery'];
		$handle = fopen($target_path, "rb");
		$vid_contents = fread($handle, filesize($target_path));
		$timestamp = time();
		//$path = dirname(__FILE__)."/".$target_path;
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_URL, 'http://tsg.emantras.com/ichitter_service/webservice.php' );
		curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'video_upload_service.php' );
		//most importent curl assues @filed as file field
		$post_array = array(
			"my_file_binary"=>base64_encode($vid_contents),
			"my_file_name"=>$timestamp."_".$_FILES['multiplefile']['name'][$i],
			"user_id"=>$user_id,		
			"gallery"=>$gallery,				
			"upload"=>"Upload"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
		$response = curl_exec($ch);*/

		$curl_data = array(
			"my_file_binary"=>base64_encode($vid_contents),
			"my_file_name"=>$timestamp."_".$_FILES['multiplefile']['name'][$i],
			"user_id"=>$user_id,		
			"gallery"=>$gallery,				
			"upload"=>"Upload" );
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(VIDEO_UPLOAD_SERVICE, $curl_data);
		$response = $curl_call->response;

		//echo $response;
		//$response_decode = json_decode($response);
		$response_decode = $ObjJSON->decode($response);		
		$successmsg = $response_decode->{'success'};
		if($successmsg == "Video uploaded successfully"){
		 $path = $target_path;
		 header('Location: videos.php?msg=vidsuccess');
		//unlink($path);
		}else{
		 header('Location: videos.php?msg=vidsuccess');
		}
	} else{
		header('Location: videos.php?msg=error');
	}
  } 
 }else{
  if($_FILES['multiplefile']['error'][$i] == 1){
    header('Location: videos.php?msg=maxSize');
  }
  
 } 
}
?>