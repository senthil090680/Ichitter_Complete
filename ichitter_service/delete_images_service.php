<?php
require_once "includes/dbobj.php";
require_once "includes/json.php";
class delete_photos{
    
        private $image_ids;
        private $user_id;
        private $json_error_arr = array();  
        private $ObjJSON;   
        
    function __construct(){
		$this->ObjJSON = new Services_JSON();
    }
	function _delete_photos($image_ids,$user_id){
	  $img = explode(",",$image_ids);
      foreach($img as $imgid){
	    $sql = "SELECT image_name,igallery_id FROM tbl_images WHERE image_id = $imgid";
		$rs = mysql_query($sql);
		$fetch = mysql_fetch_array($rs);
		$img_name = $fetch['image_name'];
		$igallery_id = $fetch['igallery_id'];
		$gal_name = $this->_get_galleryname($user_id,$igallery_id);
		$rmpath = "upload/photos/".$user_id."/".$gal_name."/".$img_name;
		
		$rmthmbpath = "upload/photos/".$user_id."/".$gal_name."/thumb/".$img_name;
		unlink($rmpath);	
		unlink($rmthmbpath);
	    $sql = "DELETE FROM tbl_images WHERE image_id = $imgid";
		$rs = mysql_query($sql);	
	  }
        if($rs){
		  $return["success"] = "Image deleted successfully";
		  $return["gal_id"] = $igallery_id;
		}		
	    //return json_encode($return);
	    return $this->ObjJSON->encode($return);	 
	}
	function _get_galleryname($user_id,$gallery){
		$strSQL = "SELECT igallery_name,user_id FROM tbl_igallery WHERE igallery_id = '$gallery' AND  user_id='$user_id'";
		$rs = mysql_query($strSQL);
        $fetch = mysql_fetch_array($rs);
        $igallery_name = $fetch['igallery_name'];		
        $user_id = $fetch['user_id'];		
        return $galname = $igallery_name;		
	}	

}	
$image_ids = $_POST['image_ids'];
$user_id = $_POST['user_id'];
$post_upload = $_POST['upload'];
$delete_obj = new delete_photos();
if(isset($post_upload)){
if($_POST["delete_photos"] != ""){
echo $fetch_photos = $delete_obj->_delete_photos($image_ids,$user_id);
}
//if($_POST["get_gallery"] != ""){
//echo $fetch_gallery = $gallery_obj->_fetch_galaries($user_id);
//}
}
?>