<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
class fetch_photos_gallery{

        private $user_id;
        private $json_error_arr = array();     
        private $ObjJSON;
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _fetch_photos_galleries($user_id){
	 $strSQL = "SELECT * FROM tbl_igallery WHERE user_id='$user_id' ORDER BY igallery_name";
	 $rs = mysql_query($strSQL);	
	 $cnt = 0;	
	 while($fetch_img = mysql_fetch_array($rs)){			
		$igallery_id = $fetch_img['igallery_id'];		
		$igallery_name = $fetch_img['igallery_name'];
		$img_urls[] = $igallery_name;
		$img_urls[] = $igallery_id;
		$cnt++;	
     }
     if($cnt == 0){
	  $return['error'] = "No Gallery Available";
	 }else{		 
	  $return['success'] = $img_urls;
	 } 
    //return json_encode($return);
    return $this->ObjJSON->encode($return); 
	}
}	
$user_id = $_POST['user_id'];
$post_upload = $_POST['upload'];
$gallery_obj = new fetch_photos_gallery();
if(isset($post_upload)){
if($user_id != ""){
echo $fetch_photos = $gallery_obj->_fetch_photos_galleries($user_id);
}
}
?>
