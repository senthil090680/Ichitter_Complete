<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";

class create_gallery{
    
        private $gallery_name;
        private $user_id;
        private $json_error_arr = array();   
		private $ObjJSON; 	
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();	
    }
	function _check_directory($gallery_name,$user_id){
         $thisdir = getcwd();
		if(is_dir($thisdir ."/upload/photos/".$user_id."/".$gallery_name."_".$user_id)){ 
		    $msg = "Directory created already";			
		}else{
		    $msg = "Success";
		}
return $msg;		
	}
	function _create_gallery_hit_db($gallery_name,$user_id){
	  $gallery_name = $gallery_name."_".$user_id;
	  $query = "INSERT INTO `tbl_igallery` (`igallery_id`, `user_id`, `igallery_name`, `date_uploaded`, `date_last_updated`, `is_active`)
											   VALUES (NULL, '$user_id', '$gallery_name', now(), now(), 1);";
	  mysql_query($query);										   
	}
    function _gallery_make($gallery_name,$user_id){
         $thisdir = getcwd();
		if(mkdir($thisdir ."/upload/photos/".$user_id."/".$gallery_name."_".$user_id , 0777, true)){		
			mkdir($thisdir ."/upload/photos/".$user_id."/thumb" , 0777, true);
			mkdir($thisdir ."/upload/photos/".$user_id."/".$gallery_name."_".$user_id."/thumb" , 0777, true);
			$this->_create_gallery_hit_db($gallery_name,$user_id);		
			$msg = "Directory has been created successfully";        
		}else{
		    $msg = "Failed to create directory";			
		}
return $msg;		
    }
   
}
$gallery_name = $_POST['gallery_name'];
$user_id = $_POST['user_id'];
$post_upload = $_POST['upload'];
$gallery_obj = new create_gallery();
$ObjJSON = new Services_JSON();
//$db = new DBHandler();
$check_dir = $gallery_obj->_check_directory($gallery_name,$user_id);
if(isset($post_upload)){
 if($check_dir == "Success"){
  $arr_success['success'] = $gallery_obj->_gallery_make($gallery_name,$user_id);
  //echo $responseVar = json_encode($arr_success);
  echo $responseVar = $ObjJSON->encode($arr_success); 
  }else{
  $arr_success['error'] = $gallery_obj->_check_directory($gallery_name,$user_id);
  //echo $responseVar = json_encode($arr_success);
  echo $responseVar = $ObjJSON->encode($arr_success); 
  }
}
?>