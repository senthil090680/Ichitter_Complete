<?php
require_once('lib/include_files.php');
//error_reporting(0);
$delete_images = $_POST['deleteAlbum'];
$delet = implode(",",$delete_images);
$user_id= $_POST['user_id'];
if($user_id != ""){
		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_URL, SERVICE_NAME . 'delete_album_service.php' );
		//most importent curl assues @filed as file field
		$post_array = array(
			"album_ids"=>$delet,
			"user_id"=>$user_id,			
			"upload"=>"Upload",
			"delete_album"=>"delete"			
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array); 
		$response = curl_exec($ch);
		//echo $response;*/
		
		$curl_data = array(
			"album_ids"=>$delet,
			"user_id"=>$user_id,
			"upload"=>"Upload",
			"delete_album"=>"delete");
		$curl_data+=$REQ_SEND;
		$curl_call = new INIT_PROCESS(DELETE_ALBUM_SERVICE, $curl_data);
		$response = $curl_call->response;
		
		//$response_decode = json_decode($response);	
		$response_decode = $ObjJSON->decode($response);
		$successmsg = $response_decode->{'success'};
		if($successmsg == "Album deleted successfully"){
		 header('Location: photos.php?msg=Adelsuccess');
		}else{
		 header('Location: photos.php?msg=Adelerror');
		}
}	
?>