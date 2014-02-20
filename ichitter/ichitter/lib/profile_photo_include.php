<?php

$data = array('action'=>'get_user_record','user_id'=>$session_obj->get_Session('user_id')); 
$data += $REQ_SEND;	
$init_process_obj = new INIT_PROCESS(SERVICE_NAME.'registration_service.php',$data);
 $user_data = (array)($ObjJSON->decode($init_process_obj->response));
 /*echo '<pre />';
 print_r($user_data);*/
 /*if(isset($user_data['image_name']) && trim($user_data['image_name']) != ''){
  $profile_img = IMAGE_UPLOAD_SERVER. $user_data['user_id'] ."/". $user_data['igallery_name'] ."/". $user_data['image_name'];
 }else{
  $profile_img = "resource/images/profile-img1.jpg";
 }*/
 
 if (isset($user_data['image_name']) && trim($user_data['image_name']) != '') {

    if (isset($user_data['igallery_name'])) {
        $profile_img = IMAGE_UPLOAD_SERVER . $user_data['user_id'] . "/" . $user_data['igallery_name'] . "/" . $user_data['image_name'];
    } else {
        $profile_img = IMAGE_UPLOAD_SERVER . $user_data['user_id'] . "/" . $user_data['image_name'];
    }
} else {
    if ($user_data['gender'] == 'm') {
        $profile_img = "resource/images/male-small.jpg";
    } elseif ($user_data['gender'] == 'f') {
        $profile_img = "resource/images/female-small.jpg";
    }
}
 
 $user_name = $user_data['first_Name']." ".$user_data['last_Name'];


?>